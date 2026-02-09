<x-filament-panels::page.simple>

        <div class="min-h-screen bg-cover">
            <div class="min-h-screen bg-black/50 flex items-center justify-center">
                <!-- لوگوها و پرچم بالای صفحه -->
                <div class="absolute top-4 left-0 right-0 flex flex-col items-center gap-4">
                    <img src="{{ asset('images/flag-iran.png') }}" alt="پرچم ایران" class="h-16">
                    <div class="flex gap-8">
                        <img src="/images/logo-nusazi.png" alt="نوسازی مدارس" class="h-20">
                        <img src="/images/logo-amuzesh.png" alt="آموزش و پرورش" class="h-20">
                        <img src="/images/logo-kheyrin.png" alt="خیرین مدرسه‌ساز" class="h-20">
                    </div>
                </div>

                <!-- فرم لاگین وسط -->
                <div class="w-full max-w-md">
                    {{ $this->form }}
                </div>

                <!-- عکس امام و رهبری پایین -->
                <div class="absolute bottom-4 left-0 right-0 flex justify-center">
                    <img src="/images/emam-rahbari.png" alt="امام و رهبری" class="h-32 rounded-lg shadow-lg">
                </div>
            </div>
        </div>
</x-filament-panels::page.simple>
