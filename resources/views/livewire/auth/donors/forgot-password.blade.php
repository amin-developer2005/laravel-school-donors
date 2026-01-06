<div class="flex flex-col gap-6">
    <x-auth-header :title="__('فراموشی رمز عبور')"
                   :description="__('حیر محترم در صورتی که رمز عبور خود را فراموش کرده اید, می توانید با وارد کردن ایمیلی که با آن داخل سامانه ثبت کرده اید, نسبت به تغییر رمز خود اقدام نمایید')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('ایمیل')"
            type="email"
            required
            autofocus
            placeholder="email@outlook.com"
        />

        <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
            {{ __('ارسال لینک تغییر رمز عبور') }}
        </flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
        <span>{{ __('یا, بر گرد به') }}</span>
        <flux:link :href="route('donors.login')" wire:navigate>{{ __('لاگین') }}</flux:link>
    </div>
</div>
