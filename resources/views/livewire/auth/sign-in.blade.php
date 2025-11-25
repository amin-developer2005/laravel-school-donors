<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-600 via-pink-500 to-red-500 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-bold text-gray-800">خوش اومدی回来</h2>
                <p class="text-gray-600 mt-2">به حساب کاربریت وارد شو</p>
            </div>

            <form wire:submit="login" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ایمیل</label>
                    <input type="email" wire:model="email" required
                           class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-4 focus:ring-purple-200 transition duration-200 outline-none bg-white/70"
                           placeholder="you@example.com">
                    @error('email') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">رمز عبور</label>
                    <input type="password" wire:model="password" required
                           class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-4 focus:ring-purple-200 transition duration-200 outline-none bg-white/70"
                           placeholder="••••••••">
                    @error('password') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="remember" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <span class="mr-2 text-gray-600">مرا به یاد داشته باش</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-purple-600 hover:text-purple-800 font-medium">
                        فراموش کردی؟
                    </a>
                </div>

                <flux:button type="submit" variant="primary" class="w-full transform hover:scale-[1.02] transition-all duration-300 shadow-lg">ورود</flux:button>

            </form>

            <p class="text-center mt-8 text-gray-600">
                حساب نداری؟
                <a href="{{ route('register') }}" class="text-purple-600 font-bold hover:text-purple-800" wire:navigate>ثبت‌نام کن</a>
            </p>
        </div>
    </div>
</div>
