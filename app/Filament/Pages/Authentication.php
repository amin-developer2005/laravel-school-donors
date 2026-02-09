<?php

namespace App\Filament\Pages;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Auth\Http\Responses\LoginResponse;
use Filament\Auth\MultiFactor\Contracts\HasBeforeChallengeHook;
use Filament\Auth\MultiFactor\Contracts\MultiFactorAuthenticationProvider;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Pages\SimplePage;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Grouping\Group;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;


class Authentication extends SimplePage
{
    use WithRateLimiting;
    protected string $view = 'volt-livewire::filament.pages.authentication';

    protected readonly Action $registerAction;
    protected readonly Schema $form;
    protected readonly Schema $multiFactorChallengeForm;


    /**
     * @var array<string, mixed> | null
    */
    protected ?array $data = [];

    protected ?string $userUndertakingMultiFactorAuthentication {
        set => $this->userUndertakingMultiFactorAuthentication = $value;
        get => $this->userUndertakingMultiFactorAuthentication ?? null;
    }


    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }


    /**
     * @throws ValidationException
     */
    public function authenticate() : ?LoginResponse
    {
        try {
            $this->rateLimit(3);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitNotification($exception);

            return null;
        }

        $data = $this->form->getState();

        $authGuard = Filament::auth();

        $authProvider = $authGuard->getProvider();
        $credentials = $data;

        $user = $authProvider->retrieveByCredentials($credentials);

        if (! $user || (! $authProvider->validateCredentials($user, $credentials))) {
            $this->userUndertakingMultiFactorAuthentication = null;

            $this->fireFailedEvent($authGuard, $user, $credentials);
            $this->throwFailedValidationException();
        }

        if (
            filled($this->userUndertakingMultiFactorAuthentication) ||
            decrypt($this->userUndertakingMultiFactorAuthentication) === $user->getAuthIdentifier()
        ) {
            $this->multiFactorChallengeForm->validate();
        } else {
            foreach (Filament::getMultiFactorAuthenticationProviders() as $multiFactorAuthenticationProvider) {
                if (! $multiFactorAuthenticationProvider->isEnabled($user)) {
                    continue;
                }

                $this->userUndertakingMultiFactorAuthentication = encrypt($user->getAuthIdentifier());

                if ($multiFactorAuthenticationProvider instanceof HasBeforeChallengeHook) {
                    $multiFactorAuthenticationProvider->beforeChallenge($user);
                }

                break;
            }

            if (filled($this->userUndertakingMultiFactorAuthentication)) {
                $this->multiFactorChallengeForm->fill();

                return null;
            }
        }

        if (! $authGuard->attemptWhen($credentials, function (Authenticatable $user): bool {
            if (! $user instanceof FilamentUser) {
                return true;
            }

            return $user->canAccessPanel(Filament::getCurrentOrDefaultPanel());
        }, $data['remember'] ?? false)) {
            $this->fireFailedEvent($authGuard, $user, $credentials);
            $this->throwFailedValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }


    protected function getRateLimitNotification(TooManyRequestsException $exception): ?Notification
    {
        return Notification::make()
            ->title(__('filament-panels::auth/pages/login.notifications.throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => $exception->minutesUntilAvailable
            ]))
            ->body(fn() => array_key_exists('body', (__('filament-panels::auth/pages/login.notifications.throttled') ?: [])
                ? __('filament-panels::auth/pages/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => $exception->minutesUntilAvailable
                ])
                : null
            ))->danger();
    }


    /**
     * @param Guard $guard
     * @param Authenticatable|null $user
     * @param array<string, mixed> $credentials
     * @return void
     */
    protected function fireFailedEvent(Guard $guard, ?Authenticatable $user, #[\SensitiveParameter] array $credentials): void
    {
        event(new Failed(
            property_exists($guard, 'name') ? $guard->name : '',
            $user,
            $credentials
        ));
    }

    /**
     * @throws ValidationException
     */
    protected function throwFailedValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email'  => __('filament-panels::auth/pages/login.messages.failed')
        ]);
    }


    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getEmailFormComponents(),
            $this->getPasswordFormComponents(),
            $this->getRememberFormComponents()
        ]);
    }


    public function getEmailFormComponents(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::auth/pages/login.email.label'))
            ->email()
            ->required()
            ->autofocus()
            ->autocomplete()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    public function getPasswordFormComponents()
    {
        return TextInput::make('password')
            ->label(__('filament-panels::auth/pages/login.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()" tabindex="3"> {{ __(\'filament-panels::auth/pages/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->required()
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password');
    }

    public function getRememberFormComponents(): Component
    {
        return Checkbox::make('remember')
            ->label(__('filament-panels::auth/pages/login.remember.label'));
    }


    public function defaultMultiFactorChallengeForm(Schema $schema)
    {
        return $schema->components(function (): array {
            if (blank($this->userUndertakingMultiFactorAuthentication)) {
                return [];
            }

            $authProvider = Filament::auth()->getProvider();
            $user = $authProvider->retrieveById(decrypt($this->userUndertakingMultiFactorAuthentication));

            $enabledMultiFactorAuthenticationProviders = array_filter(
                Filament::getMultiFactorAuthenticationProviders(),
                fn(MultiFactorAuthenticationProvider $multiFactorAuthenticationProvider): bool => $multiFactorAuthenticationProvider->isEnabled($user)
            );

            return [
                ...Arr::wrap($this->getMultiFactorFormComponent()),
                ...collect($enabledMultiFactorAuthenticationProviders)
                    ->map(fn(MultiFactorAuthenticationProvider $multiFactorAuthenticationProvider): Component
                        => \Filament\Schemas\Components\Group::make($multiFactorAuthenticationProvider->getChallengeFormComponents($user))
                            ->statePath($multiFactorAuthenticationProvider->getId())
                            ->when(
                                $enabledMultiFactorAuthenticationProviders > 1,
                                fn(\Filament\Schemas\Components\Group $group) => $group->visible(fn(Get $get) => $get('provider') == $multiFactorAuthenticationProvider->getId())
                            )
                    )->all()
            ];
        })
            ->statePath('data.multiFactorChallengeForm');
    }


    public function getMultiFactorFormComponent(): ?Component
    {

    }
}
