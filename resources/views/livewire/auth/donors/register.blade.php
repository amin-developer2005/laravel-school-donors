
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('ایجاد حساب کاربری')" :description="__('خیر محترم جهت ساخت حساب کاربری خود اطلاعات مورد نیاز را وارد نمایید.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" wire:submit="store" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="username"
                wire:model="username"
                :label="__('نام')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('نام کامل')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                wire:model="email"
                :label="__('ایمیل')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="youremail@outlook.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                wire:model="password"
                :label="__('پسوورد')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('پسورد')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                wire:model="password_confirmation"
                :label="__('تایید پسوورد')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('تایید پسوورد')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full transform hover:scale-[1.02] transition-all duration-300 shadow-lg" data-test="register-user-button">
                    {{ __('ساخت حساب کاربری') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('آیا قبلا حساب خود را ایجاد کرده اید?') }}</span>
            <flux:link :href="route('donors.login')" wire:navigate>{{ __('وارد شوید') }}</flux:link>
        </div>
    </div>
