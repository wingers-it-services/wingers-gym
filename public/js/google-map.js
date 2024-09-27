document.addEventListener("DOMContentLoaded", function () {
    function initMap() {
        var centerLocation = { name: "WITS Office", coords: [21.6414269, 73.0121917] };  

        var map = L.map('map').setView(centerLocation.coords, 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker(centerLocation.coords).addTo(map)
            .bindPopup(centerLocation.name)
            .openPopup();

        addNearbyLocations(centerLocation.coords, map);
    }

    function generateNearbyLocation(center, maxDistance) {
        var latOffset = (Math.random() - 0.5) * (maxDistance / 111320);
        var lngOffset = (Math.random() - 0.5) * (maxDistance / (111320 * Math.cos(center[0] * Math.PI / 180)));
        return [center[0] + latOffset, center[1] + lngOffset];
    }

    function addNearbyLocations(center, map) {
        var locations = [
            { name: "Gym 1", coords: generateNearbyLocation(center, 500) },
            { name: "Gym 2", coords: generateNearbyLocation(center, 500) },
            { name: "Gym 3", coords: generateNearbyLocation(center, 500) }
        ];

        locations.forEach(function(location) {
            L.marker(location.coords).addTo(map)
                .bindPopup(location.name);
        });
    }

    initMap();
});
