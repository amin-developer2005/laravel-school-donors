<x-mail::message>
    بازیابی رمز عبور



    <p>سلام،</p>
    <p>شما این ایمیل را دریافت کرده‌اید چون درخواست بازیابی رمز عبور داده‌اید.</p>
    <p>
        برای تغییر رمز عبور خود، روی لینک زیر کلیک کنید:
    </p>

    <x-mail::button :url="url(route('password.reset', ['email' => $email, 'token' => $token]), false)" >
        بازیابی رمز عبور
    </x-mail::button>


    {{ config('app.name') }}
</x-mail::message>
