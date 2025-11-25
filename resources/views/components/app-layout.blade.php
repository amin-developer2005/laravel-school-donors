<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" xmlns:flux="http://www.w3.org/1999/html">
    <head>
        @include('partials.head')
    </head>

    <body class="min-h-screen bg-white dark:bg-[#0a0a0a]">
    <flux:header container class="border-b dark:bg-zinc-700">
        <!-- هدر (Navbar) -->
        <flux:navbar class="py-7 px-10 flex items-center justify-between gap-20 flex-nowrap max-w-screen w-full">


            <div class="flex space-x-reverse gap-x-4 justify-end">
                <flux:button variant="primary" href="{{ route('donors.login') }}">ورود / ثبت نام خیرین</flux:button>
{{--                <flux:button variant="filled" href="{{ route('donors.register') }}"> خیرین</flux:button>--}}
            </div>


            <div class="flex justify-center items-center gap-x-4 rtl:space-x-reverse">
                <x-app.button route="home">خیرین</x-app.button>
                <x-app.button route="home"> پروژه ها</x-app.button>
                <x-app.button route="filament.admin.pages.dashboard">پنل ادمین</x-app.button>
                <x-app.button route="home">خانه</x-app.button>
            </div>

            <a href="/" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0 justify-start" wire:navigate>
                <x-app-logo />
            </a>

            <div class="md:hidden flex items-center">
                <flux:button  variant="ghost" x-on:click="open = !open" />  <!-- آیکون همبرگر -->
                <flux:dropdown x-show="open" class="absolute top-full right-0 mt-2 w-48 bg-white dark:bg-zinc-800 shadow-lg rounded-lg">
                    <!-- محتوای منو برای موبایل -->

                    <flux:menu>

                        <flux:menu.radio.group>
                            <flux:menu.item href="{{ route('dashboard') }}">پنل ادمین</flux:menu.item>
                            <flux:menu.item href="{{ route('home') }}">خانه</flux:menu.item>
                            <!-- دکمه‌های اضافی -->
                            <flux:menu.item href="{{ route('home') }}">پروژه‌ها</flux:menu.item>
                            <flux:menu.item href="{{ route('home') }}">درباره ما</flux:menu.item>
                            <flux:menu.separator />
                            <flux:menu.item href="{{ route('donors.login') }}">ورود</flux:menu.item>
                            <flux:menu.item href="{{ route('donors.register') }}">ثبت ‌نام</flux:menu.item>
                        </flux:menu.radio.group>
                    </flux:menu>

                </flux:dropdown>
            </div>
        </flux:navbar>
    </flux:header>

    {{ $slot }}

    @fluxScripts
    </body>
</html>
