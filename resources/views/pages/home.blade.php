    <x-app-layout>
                <!-- Hero Section -->
                <livewire:home.hero-section />

                <!-- Statistics Section -->
                <section class="py-12 bg-zinc-900">
                    <div class="container mx-auto px-4">
                        <livewire:home.statistics />
                    </div>
                </section>

                <!-- Featured Projects Section -->
                <section class="py-12">
                    <div class="container mx-auto px-4">
                        <h2 class="text-3xl font-bold text-center mb-8">پروژه‌های برجسته</h2>
{{--                        <livewire:home.featured-projects />--}}
                    </div>
                </section>

                <!-- Success Stories Section -->
                <section class="py-12 bg-zinc-900">
                    <div class="container mx-auto px-4">
                        <h2 class="text-3xl font-bold text-center mb-8">داستان‌های موفقیت</h2>
{{--                        <livewire:home.success-stories />--}}
                    </div>
                </section>

                <!-- Call to Action -->
                <section class="py-12 bg-blue-600 text-white text-center">
                    <div class="container mx-auto px-4">
                        <h2 class="text-3xl font-bold mb-4">به ما بپیوندید و تغییری ایجاد کنید!</h2>
                        <p class="mb-6">با کمک شما، هزاران کودک به آموزش دسترسی پیدا می‌کنند.</p>
                        @if(\Illuminate\Support\Facades\Route::has('projects.index'))
                            <a href="{{ route('projects.index') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg">مشاهده پروژه‌ها</a>
                        @endif
                    </div>
                </section>
    </x-app-layout>


