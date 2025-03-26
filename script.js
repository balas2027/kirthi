// Initialize map
var map = L.map('map').setView([13.0827, 80.2707], 10); // Chennai coordinates

// Add OpenStreetMap Tile Layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Function to assign different colors based on property
function getColor(feature) {
    let id = feature.properties.zone || feature.properties.ward || feature.properties.district;

    if (!id) return 'blue'; // Default if no valid property

    let colors = ['yellow', 'blue', 'red', 'orange'];
    return colors[id.length % colors.length]; // Assign colors dynamically
}

// Style function for GeoJSON features
function styleFeature(feature) {
    return {
        fillColor: getColor(feature),
        weight: 1.5,
        opacity: 1,
        color: 'black',
        fillOpacity: 0.5
    };
}

// Load Chennai GeoJSON
fetch('chennai.geojson')
    .then(response => response.json())
    .then(data => {
        L.geoJSON(data, {
            style: {
                color: "red",  // Change color to make it visible
                weight: 2
            }
        }).addTo(map);
    })
    .catch(error => console.error('Error loading GeoJSON:', error));
