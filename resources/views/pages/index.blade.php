{{-- resources/views/home.blade.php --}}
    <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سامانه خیرین مدرسه‌ساز ایران | با هم کلاس درس بسازیم</title>
    <meta name="description" content="با کمک شما، هیچ دانش‌آموزی در ایران بدون کلاس درس نمی‌ماند.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind + Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
    </style>

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Swiper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body class="bg-gray-50 text-gray-800">

{{-- Navigation --}}
<nav class="fixed top-0 left-0 right-0 bg-white shadow-lg z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                <img src="https://via.placeholder.com/180x60/0D99FF/ffffff?text=خیرین+مدرسه‌ساز" alt="لوگو" class="h-12">
            </div>
            <div class="hidden md:flex items-center space-x-reverse space-x-8 text-lg font-medium">
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">خانه</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">پروژه‌ها</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">خیرین</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">مدارس</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">بلاگ</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">تماس با ما</a>
                <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition font-bold">همین حالا کمک کنید</a>
            </div>
            <div class="md:hidden">
                <button class="text-gray-700">☰</button>
            </div>
        </div>
    </div>
</nav>

{{-- Hero Section --}}
<section class="relative h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1582213782179-1d2a1d7d7828?w=1920&q=80');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative text-center text-white px-6 max-w-4xl mx-auto" data-aos="fade-up">
        <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
            با هم ایران را پر از کلاس درس کنیم
        </h1>
        <p class="text-2xl md:text-3xl mb-10">
            تا امروز <span class="font-bold text-yellow-400">۱,۸۴۷</span> کلاس درس با کمک <span class="font-bold text-yellow-400">۲۸,۹۳۴</span> خیر عزیز ساخته شده
        </p>
        <div class="space-x-reverse space-x-6">
            <a href="{{ route('donors.login') }}" class="bg-green-500 text-white px-10 py-5 rounded-full text-xl font-bold hover:bg-green-600 transition inline-block">شروع کمک مالی</a>
            <a href="#" class="border-2 border-white text-white px-10 py-5 rounded-full text-xl font-bold hover:bg-white hover:text-gray-800 transition inline-block">مشاهده پروژه‌ها</a>
        </div>
    </div>
</section>

{{-- Counter Section --}}
<section class="py-20 bg-blue-50">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-10 text-center">
        <div data-aos="fade-up">
            <h3 class="text-5xl font-bold text-blue-600 counter" data-count="2341">0</h3>
            <p class="text-xl mt-2">پروژه تکمیل شده</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-5xl font-bold text-green-600 counter" data-count="487">0</h3>
            <p class="text-xl mt-2">پروژه در حال ساخت</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="400">
            <h3 class="text-5xl font-bold text-purple-600 counter" data-count="32">0</h3>
            <p class="text-xl mt-2">میلیارد تومان کمک جمع‌شده</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="600">
            <h3 class="text-5xl font-bold text-orange-600 counter" data-count="31">0</h3>
            <p class="text-xl mt-2">استان تحت پوشش</p>
        </div>
    </div>
</section>

{{-- How it works --}}
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-16">چطور کار می‌کنه؟</h2>
        <div class="grid md:grid-cols-4 gap-10">
            <div data-aos="zoom-in">
                <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">۱</div>
                <p class="text-xl font-semibold">انتخاب پروژه</p>
            </div>
            <div data-aos="zoom-in" data-aos-delay="200">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">۲</div>
                <p class="text-xl font-semibold">پرداخت امن آنلاین</p>
            </div>
            <div data-aos="zoom-in" data-aos-delay="400">
                <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">۳</div>
                <p class="text-xl font-semibold">گزارش تصویری پیشرفت</p>
            </div>
            <div data-aos="zoom-in" data-aos-delay="600">
                <div class="bg-orange-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">۴</div>
                <p class="text-xl font-semibold">افتتاح و نام‌گذاری به نام شما</p>
            </div>
        </div>
    </div>
</section>

{{-- Urgent Projects Slider --}}
<section class="py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12">این مدارس همین امروز به کمک شما نیاز دارن</h2>
        <div class="swiper urgentSlider">
            <div class="swiper-wrapper">
                @for($i = 1; $i <= 6; $i++)
                    <div class="swiper-slide">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <img src="https://via.placeholder.com/600x400/4F46E5/ffffff?text=مدرسه+{{ $i }}" alt="پروژه" class="w-full h-64 object-cover">
                            <div class="p-6">
                                <h4 class="text-2xl font-bold mb-2">دبستان امید - سیستان و بلوچستان</h4>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-green-600 font-bold">۷۸٪ پیشرفت</span>
                                    <span class="text-red-600 font-bold">نیاز: ۴۲ میلیون تومان</span>
                                </div>
                                <div class="w-full bg-gray-300 rounded-full h-3 mb-4">
                                    <div class="bg-green-500 h-3 rounded-full" style="width: 78%"></div>
                                </div>
                                <a href="#" class="block text-center bg-blue-600 text-white py-3 rounded-full font-bold hover:bg-blue-700 transition">کمک به این پروژه</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

{{-- Success Stories --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-16">داستان‌های واقعی موفقیت</h2>
        <div class="grid md:grid-cols-3 gap-10">
            @for($i = 1; $i <= 3; $i++)
                <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-lg" data-aos="fade-up">
                    <img src="https://via.placeholder.com/600x400/10B981/ffffff?text=قبل+و+بعد" alt="قبل و بعد" class="w-full">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-4">مدرسه امید - روستای چاه‌مبارک</h3>
                        <p class="text-gray-600 leading-relaxed">"با کمک ۴۷ خیر عزیز در ۹۰ روز ساخته شد. حالا ۱۲۰ دانش‌آموز کلاس درس دارن."</p>
                        <a href="#" class="text-blue-600 font-bold mt-4 inline-block">ادامه داستان →</a>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

{{-- Newsletter --}}
<section class="py-20 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-6">اولین نفری باش که از پروژه‌های جدید باخبر می‌شه</h2>
        <form class="flex flex-col md:flex-row gap-4 max-w-xl mx-auto">
            <input type="email" placeholder="ایمیل خود را وارد کنید" class="px-6 py-4 rounded-full text-gray-800 text-lg flex-1">
            <button class="bg-green-500 hover:bg-green-600 text-white px-10 py-4 rounded-full font-bold text-lg transition">اشتراک</button>
        </form>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-10">
        <div>
            <img src="https://via.placeholder.com/180x60/ffffff/333333?text=خیرین+مدرسه‌ساز" alt="لوگو" class="h-12 mb-6">
            <p>با هم ایران را پر از لبخند دانش‌آموزان کنیم.</p>
        </div>
        <div>
            <h4 class="font-bold text-xl mb-6">لینک‌های سریع</h4>
            <ul class="space-y-3">
                <li><a href="#" class="hover:text-blue-400">پروژه‌ها</a></li>
                <li><a href="#" class="hover:text-blue-400">گزارش مالی</a></li>
                <li><a href="#" class="hover:text-blue-400">تماس با ما</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold text-xl mb-6">تماس با ما</h4>
            <p>تلفن: </p>
            <p>واتساپ: </p>
        </div>
        <div>
            <h4 class="font-bold text-xl mb-6">نمادهای اعتماد</h4>
            <div class="flex space-x-reverse space-x-4">
                <img src="https://via.placeholder.com/80x80" alt="نماد اعتماد">
                <img src="https://via.placeholder.com/80x80" alt="درگاه پرداخت">
            </div>
        </div>
    </div>
    <div class="text-center mt-10 border-t border-gray-700 pt-8">
        <p>&copy; ۱۴۰۴ سامانه خیرین مدرسه‌ساز ایران - همه حقوق محفوظ است.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    AOS.init({ duration: 1000 });

    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-count');
            const count = +counter.innerText;
            const speed = 200;
            const inc = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + inc) + (target > 1000 ? '' : '');
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target.toLocaleString('fa-IR');
            }
        };
        const observer = new IntersectionObserver(entries => {
            if (entries[0].isIntersecting) updateCount();
        }, { threshold: 0.5 });
        observer.observe(counter);
    });

    // Swiper
    new Swiper('.urgentSlider', {
        loop: true,
        autoplay: { delay: 4000 },
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: { el: '.swiper-pagination', clickable: true },
        breakpoints: {
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });
</script>
</body>
</html>
