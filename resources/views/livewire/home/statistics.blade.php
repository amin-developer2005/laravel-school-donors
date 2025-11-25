<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center" x-data="{ count: 0 }">
        <h3 class="text-4xl font-bold text-blue-600" x-text="count"></h3>
        <p class="text-gray-600">مدرسه ساخته‌شده</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg text-center" x-data="{ count: 0 }">
        <h3 class="text-4xl font-bold text-green-600" x-text="count + ' میلیون'"></h3>
        <p class="text-gray-600">تومان جمع‌آوری‌شده</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg text-center" x-data="{ count: 0 }">
        <h3 class="text-4xl font-bold text-blue-600" x-text="count"></h3>
        <p class="text-gray-600">خیرین فعال</p>
    </div>
</div>
<!-- Alpine.js برای انیمیشن شمارنده‌ها (در layout لود کن) -->
