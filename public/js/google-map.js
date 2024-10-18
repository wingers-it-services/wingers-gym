document.addEventListener("DOMContentLoaded", function () {
    function initMap() {
        var centerLocation = { name: "WITS Office", coords: [21.6414269, 73.0121917] };

        var map = L.map('map').setView(centerLocation.coords, 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© WITS Fitness'
        }).addTo(map);

        L.marker(centerLocation.coords).addTo(map)
            .bindPopup(centerLocation.name)
            .openPopup();

            loadUserLocations(map,1000);
        // Call the function with desired parameters for distance and number of locations
        addNearbyLocations(centerLocation.coords, map, 10000, 50); // Distance: 10km, Number of Locations: 20
    }

    function loadUserLocations(map,numberOfLocations) {
        // Make an AJAX request to fetch user locations
        $.ajax({
            url: '/user-locations', // Replace with your backend route URL
            method: 'GET',
            success: function(response) {
                if (response.length < numberOfLocations) {
                    console.log(response);
                    response.forEach(function(location) {
                        if (location.latitude && location.longitude) {
                            // Parse latitude and longitude as floating-point numbers
                            var latitude = parseFloat(location.latitude);
                            var longitude = parseFloat(location.longitude);
                    
                            if (!isNaN(latitude) && !isNaN(longitude)) { // Check if the parsing was successful
                                var coords = [latitude, longitude];
                                // Add marker to the map
                                L.marker(coords).addTo(map)
                                    .bindPopup( location.firstname);
                            } else {
                                console.error('Invalid coordinates for location:', location);
                            }
                        }
                    });
                    
                } else {
                    console.log("No user locations found.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching user locations: ", error);
            }
        });
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
