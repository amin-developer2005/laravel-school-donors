<x-filament::page>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div id="projects-map" style="height: 640px; border:1px solid #e5e7eb; border-radius:6px;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const center = [34.6399, 50.8759];
            const map = L.map('projects-map').setView(center, 9);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const projects = @json($this->projects);

            const markers = [];

            projects.forEach(function(p) {
                const lat = parseFloat(p.latitude);
                const lng = parseFloat(p.longitude);
                if (!isNaN(lat) && !isNaN(lng)) {
                    const marker = L.marker([lat, lng]).addTo(map);

                    const title = p.title ?? '';
                    const address = p.address ?? '';
                    const year = p.start_year ?? ''; // اگر column نامش فرق داره همین خط را اصلاح کن

                    const popupContent = `
                <div style="direction: rtl; text-align: right; min-width:200px;">
                    <strong style="display:block; margin-bottom:4px;">${escapeHtml(title)}</strong>
                    <div style="font-size:0.9rem; margin-bottom:4px;"><strong>آدرس:</strong> ${escapeHtml(address)}</div>
                    <div style="font-size:0.9rem;"><strong>سال ساخت:</strong> ${escapeHtml(year.toString())}</div>
                </div>
            `;

                    marker.bindPopup(popupContent);
                    markers.push(marker);
                }
            });

            if (markers.length) {
                const group = L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.2));
            }

            function escapeHtml(text) {
                if (!text) return '';
                return String(text)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }
        });
    </script>
</x-filament::page>
