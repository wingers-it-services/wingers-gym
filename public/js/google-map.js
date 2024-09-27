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

        // Call the function with desired parameters for distance and number of locations
        addNearbyLocations(centerLocation.coords, map, 10000, 50); // Distance: 10km, Number of Locations: 20
    }

    function generateNearbyLocation(center, maxDistance) {
        var latOffset = (Math.random() - 0.5) * (maxDistance / 111320);
        var lngOffset = (Math.random() - 0.5) * (maxDistance / (111320 * Math.cos(center[0] * Math.PI / 180)));
        return [center[0] + latOffset, center[1] + lngOffset];
    }

    function addNearbyLocations(center, map, maxDistance, numberOfLocations) {
        var gymNames = [
            "Fitness Hub", "Health Club", "Power Gym", "Elite Fitness",
            "Wellness Center", "Fit Factory", "Strength Zone", "Flex Gym",
            "Cardio Palace", "Workout World"
        ];

        var locations = [];

        while (locations.length < numberOfLocations) {
            var newCoords = generateNearbyLocation(center, maxDistance);
            // Check for duplicates
            if (!locations.some(location => location.coords[0].toFixed(6) === newCoords[0].toFixed(6) && location.coords[1].toFixed(6) === newCoords[1].toFixed(6))) {
                locations.push({
                    name: gymNames[Math.floor(Math.random() * gymNames.length)],
                    coords: newCoords
                });
            }
        }

        locations.forEach(function (location) {
            L.marker(location.coords).addTo(map)
                .bindPopup(location.name);
        });
    }

    initMap();
});
