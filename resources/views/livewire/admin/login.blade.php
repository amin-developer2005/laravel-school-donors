<x-filament::page>
    <div class="min-h-screen bg-gray-100 flex flex-col">

        {{-- Header --}}
        <div class="bg-white shadow flex items-center justify-between px-6 py-4">
            <img src="{{ asset('images/flag-iran.png') }}" class="h-10" alt="پرچم ایران">

            <h1 class="text-xl font-bold text-gray-800">
                سامانه خیرین مدرسه‌ساز استان قم
            </h1>
        </div>

        {{-- Main --}}
        <div class="flex flex-1 flex-col lg:flex-row">

            {{-- Left visual section --}}
            <div class="lg:w-1/2 hidden lg:flex flex-col justify-center items-center bg-cover bg-center"
                 style="background-image: url('{{ asset('images/qom-haram.jpg') }}')">

                <div class="bg-white/80 p-6 rounded-xl text-center space-y-4">
                    <img src="{{ asset('images/imam.png') }}" class="h-40 mx-auto">
                    <img src="{{ asset('images/rahbar.png') }}" class="h-40 mx-auto">
                </div>
            </div>

            {{-- Login Form --}}
            <div class="lg:w-1/2 flex items-center justify-center p-6">
                <div class="w-full max-w-md">

                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="bg-white border-t py-4 flex justify-center gap-8">
            <img src="{{ asset('images/logo-nosazi.png') }}" class="h-12">
            <img src="{{ asset('images/logo-amoozesh.png') }}" class="h-12">
            <img src="{{ asset('images/logo-kheyrin.png') }}" class="h-12">
        </div>

    </div>
</x-filament::page>
