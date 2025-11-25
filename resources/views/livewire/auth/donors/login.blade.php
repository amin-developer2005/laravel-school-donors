
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('ورود خیرین')" :description="__('حیر محترم جهت ورود به حساب کاریبری لطفا ایمیل و پسورد خود را وارد نمایید')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" wire:submit.prevent="store" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                wire:model="email"
                :label="__('ایمیل')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    wire:model="password"
                    :label="__('پسورد')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('آیا پسوورد خود را فراموش کرده اید?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="rememberMe" wire:model="rememberMe" :label="__('من ار به خاطر بسپار')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full transform hover:scale-[1.02] transition-all duration-300 shadow-lg" data-test="login-button">
                    <span wire:loading.remove>{{ __('ورود') }}</span>
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('اگر حساب کاربری ندارید, می توانید') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __(' ثبت نام کنید') }}</flux:link>
            </div>
        @endif
    </div>
