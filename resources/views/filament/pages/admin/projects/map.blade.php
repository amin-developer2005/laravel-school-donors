<x-filament::page>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div id="map" style="height: 75vh; border-radius: 8px; margin-top: 1rem;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const projects = @json($projects);

            // مرکز تقریبی شهر قم (می‌تونی تغییرش بدی)
            const qomCenter = [34.6399, 50.8759];

            const map = L.map('map').setView(qomCenter, 12);

            // لایه‌ی OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: 'Leaflet | © OpenStreetMap contributors'
            }).addTo(map);

            // اضافه کردن مارکرها
            projects.forEach(project => {
                // بررسی مختصات معتبر
                if (!project.latitude || !project.longitude) return;

                // تبدیل رشته به عدد (در صورت نیاز)
                const lat = parseFloat(project.latitude);
                const lng = parseFloat(project.longitude);

                if (Number.isNaN(lat) || Number.isNaN(lng)) return;

                const marker = L.marker([lat, lng]).addTo(map);

                // محتوای popup — از مقادیر امن‌شده استفاده کن
                const title = project.title ?? 'بدون عنوان';
                const address = project.address ?? 'آدرس نامشخص';
                const year = project.start_year ?? 'نامشخص'; // اگر column نامش فرق داره همین خط را اصلاح کن

                const popupContent = `
                <div style="direction: rtl; text-align: right; min-width:200px;">
                    <strong style="display:block; margin-bottom:4px;">${escapeHtml(title)}</strong>
                    <div style="font-size:0.9rem; margin-bottom:4px;"><strong>آدرس:</strong> ${escapeHtml(address)}</div>
                    <div style="font-size:0.9rem;"><strong>سال ساخت:</strong> ${escapeHtml(year.toString())}</div>
                </div>
            `;

                marker.bindPopup(popupContent);
            });

            // تابع ساده برای فرار از کاراکترهای خطرناک در HTML
            function escapeHtml(unsafe) {
                return unsafe
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            }
    </script>
</x-filament::page>
