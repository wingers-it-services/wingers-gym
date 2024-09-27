function initMap() {
    // Specify the coordinates for the map center (latitude, longitude)
    var mapCenter = { lat: 40.7128, lng: -74.0060 }; // Example: New York City

    // Create a new map inside the .map div
    var map = new google.maps.Map(document.querySelector(".map"), {
        zoom: 12,          // Zoom level of the map
        center: mapCenter, // Set the center of the map
    });

    // Add a marker to the map at the map center
    var marker = new google.maps.Marker({
        position: mapCenter,
        map: map,
        title: "Map Center"
    });
}
