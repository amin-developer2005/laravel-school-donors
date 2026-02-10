<x-filament::page>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha512-sA+e2mM3b3GfVw2r6kq1gE6ej8sa7bQ2G9Ki3wN2G8kk/3Gf2vF8EoFv4Jr2QSWwG3I2mXk3O1f7YQFhYk1YzQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha512-p8f4g8Yx8X1xqf3Yd+q3qT1r3l6r2rXyU5kz6J4d9s7s8b9bC6s2d3e4f5g6h7i8j9k0l1m2n3o4p5q6r7s8t9u=="
            crossorigin=""></script>

    <div id="map" style="height: 75vh; border-radius: 8px; margin-top: 1rem;"></div>

    <script>
        const projects = @json($projects);

        const qomCenter = [34.6399, 50.8759];

        const map = L.map('map').setView(qomCenter, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'Leaflet | © OpenStreetMap contributors'
        }).addTo(map);

        projects.forEach(project => {
            if (!project.latitude || !project.longitude) return;

            const lat = parseFloat(project.latitude);
            const lng = parseFloat(project.longitude);

            if (Number.isNaN(lat) || Number.isNaN(lng)) return;

            const marker = L.marker([lat, lng]).addTo(map);

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
