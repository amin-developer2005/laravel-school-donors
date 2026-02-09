<div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <div id="project-map" style="height: 340px; border:1px solid #e5e7eb; border-radius:6px;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // مرکز استان قم — می‌تونی تغییر بدی
            const center = [34.6399, 50.8759];
            const map = L.map('project-map').setView(center, 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let marker = null;

            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');

            function setMarker(lat, lng, pan = true) {
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], {draggable: true}).addTo(map);
                    marker.on('dragend', function(e) {
                        const pos = e.target.getLatLng();
                        if (latInput) latInput.value = pos.lat.toFixed(7);
                        if (lngInput) lngInput.value = pos.lng.toFixed(7);
                    });
                }
                if (latInput) latInput.value = parseFloat(lat).toFixed(7);
                if (lngInput) lngInput.value = parseFloat(lng).toFixed(7);
                if (pan) map.panTo([lat, lng]);
            }

            // اگر ورودی‌ها مقدار از قبل داشتند، مارکر را قرار بده
            if (latInput && lngInput && latInput.value && lngInput.value) {
                setMarker(parseFloat(latInput.value), parseFloat(lngInput.value), false);
            }

            map.on('click', function(e) {
                setMarker(e.latlng.lat, e.latlng.lng);
            });

            // اگر کاربر مقادیر را دستی ویرایش کرد، مارکر را آپدیت کن
            if (latInput && lngInput) {
                latInput.addEventListener('change', function() {
                    if (latInput.value && lngInput.value) {
                        setMarker(parseFloat(latInput.value), parseFloat(lngInput.value));
                    }
                });
                lngInput.addEventListener('change', function() {
                    if (latInput.value && lngInput.value) {
                        setMarker(parseFloat(latInput.value), parseFloat(lngInput.value));
                    }
                });
            }
        });
    </script>
</div>
