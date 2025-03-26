<?php
// Set header to ensure proper content type
header('Content-Type: text/html; charset=UTF-8');

// Check if this is an API request
$isApiRequest = strpos($_SERVER['REQUEST_URI'], '/api/') !== false;

if ($isApiRequest) {
    handleApiRequest();
    exit;
}

// If not an API request, serve the HTML page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chennai Crime Map</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        #map {
            height: 100vh;
            width: 100%;
        }
        .info-box {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }
        .info-box h4 {
            margin: 0 0 5px;
            color: hsl(0, 0%, 47%);
        }
        .legend {
            line-height: 18px;
            color: #555;
        }
        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
        .alert-popup .leaflet-popup-content-wrapper {
            background: #ffeb3b;
            color: #333;
            border-left: 5px solid #f44336;
        }
        .alert-popup-night .leaflet-popup-content-wrapper {
            background: #3f51b5;
            color: white;
            border-left: 5px solid #f44336;
        }
        .police-button {
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 1000;
            padding: 10px 15px;
            background-color: #1a237e;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        .police-button:hover {
            background-color: #283593;
        }
        .police-popup .leaflet-popup-content-wrapper {
            background: #3f51b5;
            color: white;
            border-left: 5px solid #1a237e;
        }
        .police-popup .leaflet-popup-tip {
            background: #3f51b5;
        }
        .navbar {
            background-color: #2c3e50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            color: white;
        }
        .navbar-logo {
            font-size: 20px;
            font-weight: bold;
        }
        .navbar-menu {
            display: flex;
            gap: 20px;
        }
        .navbar-menu a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .navbar-menu a:hover {
            color: #3498db;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-logo">SafeRoute</div>
        <div class="navbar-menu">
            <a href="#" >Nearest Police</a>
            <a href="#" onclick="findSafeRoute()">Safe Route</a>
            <a href="#" onclick="getCurrentLocation()">My Location</a>
            <a href="#">Emergency</a>
        </div>
    </nav>
    <div id="map"></div>
    <button id="find-police" class="police-button">Find Nearest Police Station</button>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script>
        // Initialize the map centered on Chennai
        const map = L.map('map').setView([13.0827, 80.2707], 12);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Function to get color based on crime level
        function getColor(crimeLevel) {
            return crimeLevel > 8 ? '#800026' :
                   crimeLevel > 7 ? '#BD0026' :
                   crimeLevel > 6 ? '#E31A1C' :
                   crimeLevel > 5 ? '#FC4E2A' :
                   crimeLevel > 4 ? '#FD8D3C' :
                   crimeLevel > 3 ? '#FEB24C' :
                   crimeLevel > 2 ? '#FED976' :
                              '#FFEDA0';
        }

        // Function to check if it's day or night
        function isDayTime() {
            const hour = new Date().getHours();
            return hour >= 6 && hour < 18; // 6 AM to 6 PM is considered day
        }

        // Chennai area data
        const areaCircles = <?php echo json_encode(getAreaCircles()); ?>;
        
        // Create circles for each area
        areaCircles.forEach(area => {
            const circle = L.circle(area.center, {
                color: getColor(area.crimeLevel),
                fillColor: getColor(area.crimeLevel),
                fillOpacity: 0.5,
                weight: 2,
                radius: area.radius  // Radius in meters
            }).addTo(map);

            // Add basic info popup
            circle.bindTooltip(area.area + " (Crime Level: " + area.crimeLevel + ")");

            // Add click event to show more detailed info
            circle.on('click', function() {
                const isDay = isDayTime();
                const crimeLevel = area.crimeLevel;
                let message = '';
                
                if (isDay) {
                    if (crimeLevel >= 7) {
                        message = `Attention - ${area.area}<br>Crime Level: ${crimeLevel}/10<br>High crime area! Travel in groups and stay vigilant during daytime.`;
                    } else if (crimeLevel >= 4) {
                        message = `Notice - ${area.area}<br>Crime Level: ${crimeLevel}/10<br>Moderate crime area. Be cautious of your belongings.`;
                    } else {
                        message = `Info - ${area.area}<br>Crime Level: ${crimeLevel}/10<br>Relatively safe during daytime. Normal precautions advised.`;
                    }
                } else {
                    if (crimeLevel >= 7) {
                        message = `WARNING - ${area.area}<br>Crime Level: ${crimeLevel}/10<br>Dangerous at night! Beware of thieves and suspicious activities. Avoid if possible.`;
                    } else if (crimeLevel >= 4) {
                        message = `Alert - ${area.area}<br>Crime Level: ${crimeLevel}/10<br>Night time caution advised. Watch for pickpockets and stay in well-lit areas.`;
                    } else {
                        message = `Notice - ${area.area}<br>Crime Level: ${crimeLevel}/10<br>Generally safe at night. Stay aware of surroundings.`;
                    }
                }
                
                const popupClass = isDay ? 'alert-popup' : 'alert-popup-night';
                const now = new Date();
                const timestamp = now.toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' });
                
                L.popup({ className: popupClass })
                    .setLatLng(area.center)
                    .setContent(`${message}<br>Timestamp: ${timestamp} IST`)
                    .openOn(map);
            });
        });

        // Add legend
        const legend = L.control({ position: 'bottomright' });
        legend.onAdd = function(map) {
            const div = L.DomUtil.create('div', 'info-box legend');
            const grades = [0, 3, 4, 5, 6, 7, 8, 9];
            let title = '<h4>Crime Level</h4>';
            let labels = [];

            for (let i = 0; i < grades.length; i++) {
                labels.push(
                    '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                    grades[i] + (grades[i + 1] ? '–' + grades[i + 1] + '<br>' : '+')
                );
            }

            div.innerHTML = title + labels.join('');
            return div;
        };
        legend.addTo(map);

        // Add info box
        const info = L.control({ position: 'topright' });
        info.onAdd = function(map) {
            const div = L.DomUtil.create('div', 'info-box');
            div.innerHTML = '<h4>Chennai Crime Map</h4>' +
                            'Click on an area to see safety alerts.<br>' +
                            'Current Time: <span id="current-time"></span><br>' +
                            'Mode: <span id="day-night-mode"></span>';
            return div;
        };
        info.addTo(map);

        // Update current time and mode
        function updateTimeInfo() {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString();
            document.getElementById('day-night-mode').textContent = isDayTime() ? 'Day' : 'Night';
            document.getElementById('day-night-mode').style.color = isDayTime() ? '#2196F3' : '#673AB7';
        }
        
        // Update time every second
        updateTimeInfo();
        setInterval(updateTimeInfo, 1000);

        // Simulate user location (Chennai central)
        const userLocation = L.marker([13.0827, 80.2707], {
            icon: L.icon({
                iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                shadowSize: [41, 41]
            })
        }).addTo(map);
        userLocation.bindPopup('You are here').openPopup();

        // Check location when user moves
        map.on('click', function(e) {
            // Update user marker position
            userLocation.setLatLng(e.latlng);
            
            // Check if entered a new area
            const isDay = isDayTime();
            let inDangerZone = false;
            let areaInfo = null;
            
            // Check if point is in any circle
            areaCircles.forEach(area => {
                if (pointInCircle([e.latlng.lat, e.latlng.lng], area.center, area.radius)) {
                    inDangerZone = true;
                    areaInfo = area;
                }
            });
            
            // Remove any existing popups
            map.closePopup();
            
            if (inDangerZone && areaInfo) {
                const crimeLevel = areaInfo.crimeLevel;
                let message = '';
                
                if (isDay) {
                    if (crimeLevel >= 7) {
                        message = `Attention - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>High crime area! Travel in groups and stay vigilant during daytime.`;
                    } else if (crimeLevel >= 4) {
                        message = `Notice - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Moderate crime area. Be cautious of your belongings.`;
                    } else {
                        message = `Info - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Relatively safe during daytime. Normal precautions advised.`;
                    }
                } else {
                    if (crimeLevel >= 7) {
                        message = `WARNING - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Dangerous at night! Beware of thieves and suspicious activities. Avoid if possible.`;
                    } else if (crimeLevel >= 4) {
                        message = `Alert - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Night time caution advised. Watch for pickpockets and stay in well-lit areas.`;
                    } else {
                        message = `Notice - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Generally safe at night. Stay aware of surroundings.`;
                    }
                }
                
                const popupClass = isDay ? 'alert-popup' : 'alert-popup-night';
                const now = new Date();
                const timestamp = now.toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' });
                
                userLocation.bindPopup(
                    `${message}<br>Timestamp: ${timestamp} IST`,
                    { className: popupClass }
                ).openPopup();
            } else {
                userLocation.bindPopup('You are here - Safe Zone').openPopup();
            }
        });

        // Optional: Add real geolocation if available
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(
                (position) => {
                    const latlng = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    userLocation.setLatLng(latlng);
                    map.setView(latlng, 13);
                },
                (error) => {
                    console.error('Geolocation error:', error);
                }
            );
        }

        // Define police station icon
        const policeIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/73/73371.png', // Police badge icon
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16]
        });

        // Variable to store police station markers
        let policeMarkers = [];

        // Police station data
        const policeStations = <?php echo json_encode(getPoliceStations()); ?>;
        
        // Create markers for each police station
        policeStations.forEach(station => {
            const marker = L.marker(station.center, {
                icon: policeIcon
            }).addTo(map);
            
            // Add popup with station info
            marker.bindPopup(`
                <strong>${station.name}</strong><br>
                Address: ${station.address}<br>
                Phone: ${station.phone}
            `, { className: 'police-popup' });
            
            // Store marker for later reference
            policeMarkers.push({
                marker: marker,
                data: station
            });
        });

        // Function to find nearest police station
        document.getElementById('find-police').addEventListener('click', function() {
            // Get current user location
            const userLatLng = userLocation.getLatLng();
            
            let nearestStation = null;
            let minDistance = Infinity;
            
            // Calculate distance to each police station
            policeStations.forEach(station => {
                const distance = calculateDistance(
                    userLatLng.lat, userLatLng.lng,
                    station.center[0], station.center[1]
                );
                
                if (distance < minDistance) {
                    minDistance = distance;
                    nearestStation = station;
                }
            });
            
            if (nearestStation) {
                // Calculate distance in km
                const distanceInKm = (minDistance / 1000).toFixed(2);
                
                // Draw a line between user and police station
                const routeLine = L.polyline([
                    userLatLng,
                    nearestStation.center
                ], {
                    color: 'blue',
                    weight: 4,
                    opacity: 0.7,
                    dashArray: '10, 10'
                }).addTo(map);
                
                // Show popup with info at police station
                L.popup({ className: 'police-popup' })
                    .setLatLng(nearestStation.center)
                    .setContent(`
                        <strong>${nearestStation.name}</strong><br>
                        Address: ${nearestStation.address}<br>
                        Phone: ${nearestStation.phone}<br>
                        Distance: ${distanceInKm} km from your location
                    `)
                    .openOn(map);
                
                // Fit map to show both user and police station
                const bounds = L.latLngBounds(userLatLng, nearestStation.center);
                map.fitBounds(bounds, { padding: [50, 50] });
                
                // Remove the line after 10 seconds
                setTimeout(() => {
                    map.removeLayer(routeLine);
                }, 10000);
            }
        });

        // Helper function to check if point is in circle
        function pointInCircle(point, center, radius) {
            const lat1 = point[0] * Math.PI / 180;
            const lon1 = point[1] * Math.PI / 180;
            const lat2 = center[0] * Math.PI / 180;
            const lon2 = center[1] * Math.PI / 180;
            
            const dlat = lat2 - lat1;
            const dlon = lon2 - lon1;
            const a = Math.sin(dlat/2)**2 + Math.cos(lat1) * Math.cos(lat2) * Math.sin(dlon/2)**2;
            const c = 2 * Math.asin(Math.sqrt(a));
            
            const R = 6371000; // Earth radius in meters
            const distance = R * c;
            
            return distance <= radius;
        }

        // Helper function to calculate distance between two points
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371000; // Earth radius in meters
            const φ1 = lat1 * Math.PI / 180;
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                      Math.cos(φ1) * Math.cos(φ2) *
                      Math.sin(Δλ/2) * Math.sin(Δλ/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

            return R * c;
        }

        // Navbar functions
        function findNearestPolice() {
            document.getElementById('find-police').click();
        }

        function findSafeRoute() {
            alert('Safe route feature coming soon!');
        }

        function getCurrentLocation() {
    if (navigator.geolocation) {
        // First get current position quickly
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = [position.coords.latitude, position.coords.longitude];
                updateUserLocation(pos);
            },
            (error) => {
                console.error('Geolocation error:', error);
                alert("Error getting your location: " + error.message);
            },
            { enableHighAccuracy: true, maximumAge: 10000, timeout: 5000 }
        );

        // Then watch for position changes
        if (window.locationWatchId) {
            navigator.geolocation.clearWatch(window.locationWatchId);
        }
        
        window.locationWatchId = navigator.geolocation.watchPosition(
            (position) => {
                const pos = [position.coords.latitude, position.coords.longitude];
                updateUserLocation(pos);
            },
            (error) => {
                console.error('Geolocation watch error:', error);
            },
            { 
                enableHighAccuracy: true,
                maximumAge: 30000,
                timeout: 27000
            }
        );
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function updateUserLocation(pos) {
    // Update user marker position
    userLocation.setLatLng(pos);
    
    // Center map to position if not manually moved
    if (!map.dragging._moved) {
        map.setView(pos, 15);
    }
    
    // Check if entered a dangerous area
    checkLocationSafety(pos);
    
    // Apply grey color to marker
    const markerElement = document.querySelector('.leaflet-marker-icon');
    if (markerElement) {
        markerElement.style.filter = 'bluescale(100%)';
        markerElement.style.opacity = '0.9';
    }
}

function checkLocationSafety(pos) {
    const isDay = isDayTime();
    let inDangerZone = false;
    let areaInfo = null;
    
    // Check if point is in any circle
    areaCircles.forEach(area => {
        if (pointInCircle(pos, area.center, area.radius)) {
            inDangerZone = true;
            areaInfo = area;
        }
    });
    
    // Remove any existing popups
    map.closePopup();
    
    if (inDangerZone && areaInfo) {
        const crimeLevel = areaInfo.crimeLevel;
        let message = '';
        
        if (isDay) {
            if (crimeLevel >= 7) {
                message = `Attention - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>High crime area! Travel in groups and stay vigilant during daytime.`;
            } else if (crimeLevel >= 4) {
                message = `Notice - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Moderate crime area. Be cautious of your belongings.`;
            } else {
                message = `Info - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Relatively safe during daytime. Normal precautions advised.`;
            }
        } else {
            if (crimeLevel >= 7) {
                message = `WARNING - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Dangerous at night! Beware of thieves and suspicious activities. Avoid if possible.`;
            } else if (crimeLevel >= 4) {
                message = `Alert - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Night time caution advised. Watch for pickpockets and stay in well-lit areas.`;
            } else {
                message = `Notice - ${areaInfo.area}<br>Crime Level: ${crimeLevel}/10<br>Generally safe at night. Stay aware of surroundings.`;
            }
        }
        
        const popupClass = isDay ? 'alert-popup' : 'alert-popup-night';
        const now = new Date();
        const timestamp = now.toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' });
        
        userLocation.bindPopup(
            `${message}<br>Timestamp: ${timestamp} IST`,
            { className: popupClass }
        ).openPopup();
    } else {
        userLocation.bindPopup('You are here - Safe Zone').openPopup();
    }
}

// Add this to your existing pointInCircle function if not already present
function pointInCircle(point, center, radius) {
    const lat1 = point[0] * Math.PI / 180;
    const lon1 = point[1] * Math.PI / 180;
    const lat2 = center[0] * Math.PI / 180;
    const lon2 = center[1] * Math.PI / 180;
    
    const dlat = lat2 - lat1;
    const dlon = lon2 - lon1;
    const a = Math.sin(dlat/2)**2 + Math.cos(lat1) * Math.cos(lat2) * Math.sin(dlon/2)**2;
    const c = 2 * Math.asin(Math.sqrt(a));
    
    const R = 6371000; // Earth radius in meters
    const distance = R * c;
    
    return distance <= radius;
}
        function emergencyContacts() {
            alert('Emergency contacts:\nPolice: 100\nAmbulance: 108\nWomen Helpline: 1091');
        }
    </script>
</body>
</html>

<?php
// Data and helper functions
function getAreaCircles() {
    return [
        ["area" => "T. Nagar", "center" => [13.0408, 80.2326], "radius" => 200, "crimeLevel" => 7],
        ["area" => "Adyar", "center" => [13.0012, 80.2565], "radius" => 250, "crimeLevel" => 4],
        ["area" => "Mylapore", "center" => [13.0365, 80.2676], "radius" => 200, "crimeLevel" => 5],
        ["area" => "Anna Nagar", "center" => [13.0846, 80.2153], "radius" => 300, "crimeLevel" => 3],
        ["area" => "Velachery", "center" => [12.9714, 80.2181], "radius" => 250, "crimeLevel" => 6],
        ["area" => "Guindy", "center" => [13.0067, 80.2206], "radius" => 200, "crimeLevel" => 5],
        ["area" => "Egmore", "center" => [13.0732, 80.2516], "radius" => 180, "crimeLevel" => 6],
        ["area" => "Porur", "center" => [13.0401, 80.1571], "radius" => 300, "crimeLevel" => 4],
        ["area" => "Nungambakkam", "center" => [13.0569, 80.2425], "radius" => 200, "crimeLevel" => 5],
        ["area" => "Kodambakkam", "center" => [13.0507, 80.2286], "radius" => 210, "crimeLevel" => 6],
        ["area" => "Mount Road (Anna Salai)", "center" => [13.0647, 80.2642], "radius" => 250, "crimeLevel" => 7],
        ["area" => "Ranganathan Street", "center" => [13.0380, 80.2300], "radius" => 150, "crimeLevel" => 8],
        ["area" => "Purasawalkam High Road", "center" => [13.0870, 80.2550], "radius" => 200, "crimeLevel" => 7],
        ["area" => "Broadway (Parrys)", "center" => [13.0890, 80.2860], "radius" => 220, "crimeLevel" => 8],
        ["area" => "Sowcarpet Market", "center" => [13.0920, 80.2790], "radius" => 170, "crimeLevel" => 7],
        ["area" => "Koyambedu Market", "center" => [13.0700, 80.1950], "radius" => 300, "crimeLevel" => 6],
        ["area" => "Velachery Main Road", "center" => [12.9750, 80.2200], "radius" => 250, "crimeLevel" => 6],
        ["area" => "OMR (Rajiv Gandhi Salai)", "center" => [12.9300, 80.2300], "radius" => 300, "crimeLevel" => 4],
        ["area" => "ECR (East Coast Road)", "center" => [12.9500, 80.2550], "radius" => 280, "crimeLevel" => 4],
        ["area" => "GST Road (Meenambakkam)", "center" => [12.9900, 80.1750], "radius" => 250, "crimeLevel" => 6],
        ["area" => "Cathedral Road", "center" => [13.0450, 80.2540], "radius" => 200, "crimeLevel" => 5],
        ["area" => "Eldams Road", "center" => [13.0330, 80.2460], "radius" => 180, "crimeLevel" => 6],
        ["area" => "G.N. Chetty Road", "center" => [13.0420, 80.2350], "radius" => 180, "crimeLevel" => 6],
        ["area" => "Wallajah Road", "center" => [13.0600, 80.2780], "radius" => 200, "crimeLevel" => 7],
        ["area" => "Mint Street", "center" => [13.0940, 80.2820], "radius" => 180, "crimeLevel" => 7],
        ["area" => "Poonamallee High Road", "center" => [13.0780, 80.2420], "radius" => 250, "crimeLevel" => 6],
        ["area" => "E.V.R. Periyar Salai", "center" => [13.0800, 80.2600], "radius" => 230, "crimeLevel" => 7],
        ["area" => "Peters Road", "center" => [13.0530, 80.2630], "radius" => 180, "crimeLevel" => 6],
        ["area" => "Luz Church Road", "center" => [13.0320, 80.2670], "radius" => 160, "crimeLevel" => 5],
        ["area" => "Sardar Patel Road", "center" => [13.0100, 80.2210], "radius" => 200, "crimeLevel" => 5],
        ["area" => "Paper Mills Road", "center" => [13.1100, 80.2450], "radius" => 220, "crimeLevel" => 6],
        ["area" => "Strahans Road", "center" => [13.1000, 80.2650], "radius" => 180, "crimeLevel" => 7],
        ["area" => "Bharathi Salai", "center" => [13.0580, 80.2750], "radius" => 190, "crimeLevel" => 7],
        ["area" => "Tondiarpet High Road", "center" => [13.1300, 80.2900], "radius" => 230, "crimeLevel" => 7],
        ["area" => "Thiruvottiyur High Road", "center" => [13.1600, 80.3000], "radius" => 250, "crimeLevel" => 6],
        ["area" => "Ambattur Industrial Estate", "center" => [13.0950, 80.1650], "radius" => 300, "crimeLevel" => 5],
        ["area" => "Mogappair East", "center" => [13.0830, 80.1750], "radius" => 220, "crimeLevel" => 4],
        ["area" => "Sholinganallur Junction", "center" => [12.9000, 80.2280], "radius" => 260, "crimeLevel" => 4],
        ["area" => "Chromepet Station Road", "center" => [12.9510, 80.1450], "radius" => 200, "crimeLevel" => 6],
        ["area" => "Korukkupet", "center" => [13.1180, 80.2780], "radius" => 210, "crimeLevel" => 7],
        ["area" => "Nungambakkam High Road", "center" => [13.0600, 80.2450], "radius" => 200, "crimeLevel" => 6],
        ["area" => "Sterling Road", "center" => [13.0650, 80.2400], "radius" => 180, "crimeLevel" => 5],
        ["area" => "Harrington Road", "center" => [13.0850, 80.2450], "radius" => 190, "crimeLevel" => 4],
        ["area" => "Medavakkam Main Road", "center" => [12.9200, 80.1900], "radius" => 230, "crimeLevel" => 5],
        ["area" => "Ennore", "center" => [13.2146, 80.3203], "radius" => 250, "crimeLevel" => 6],
        ["area" => "Minjur", "center" => [13.2788, 80.2588], "radius" => 280, "crimeLevel" => 5],
        ["area" => "Red Hills", "center" => [13.1879, 80.1989], "radius" => 300, "crimeLevel" => 5],
        ["area" => "Gummidipoondi", "center" => [13.4076, 80.1187], "radius" => 320, "crimeLevel" => 4],
        ["area" => "Sriperumbudur", "center" => [12.9677, 79.9419], "radius" => 350, "crimeLevel" => 4],
        ["area" => "Kelambakkam", "center" => [12.7963, 80.2220], "radius" => 270, "crimeLevel" => 3],
        ["area" => "Mamallapuram", "center" => [12.6208, 80.1945], "radius" => 300, "crimeLevel" => 3],
        ["area" => "Kovalam", "center" => [12.7898, 80.2512], "radius" => 240, "crimeLevel" => 4],
        ["area" => "Anakaputhur", "center" => [12.9828, 80.1267], "radius" => 220, "crimeLevel" => 5],
        ["area" => "Peerkankaranai", "center" => [12.9118, 80.0945], "radius" => 230, "crimeLevel" => 5],
        ["area" => "Navalur", "center" => [12.8460, 80.2262], "radius" => 260, "crimeLevel" => 3],
        ["area" => "Siruseri", "center" => [12.8372, 80.2028], "radius" => 280, "crimeLevel" => 3],
        ["area" => "Kattankulathur", "center" => [12.8290, 80.0428], "radius" => 300, "crimeLevel" => 4],
        ["area" => "Potheri", "center" => [12.8230, 80.0420], "radius" => 250, "crimeLevel" => 4],
        ["area" => "Manimangalam", "center" => [12.9182, 80.0435], "radius" => 270, "crimeLevel" => 5],
        ["area" => "Thiruporur", "center" => [12.7305, 80.1890], "radius" => 290, "crimeLevel" => 4],
        ["area" => "Ponmar", "center" => [12.8875, 80.1835], "radius" => 240, "crimeLevel" => 4],
        ["area" => "Muttukadu", "center" => [12.8325, 80.2418], "radius" => 260, "crimeLevel" => 3],
        ["area" => "Uthandi", "center" => [12.8705, 80.2520], "radius" => 230, "crimeLevel" => 3],
        ["area" => "Ponneri", "center" => [13.3378, 80.1949], "radius" => 310, "crimeLevel" => 5],
        ["area" => "Madhavaram Milk Colony", "center" => [13.1500, 80.2400], "radius" => 250, "crimeLevel" => 5],
        ["area" => "Manali New Town", "center" => [13.1700, 80.2700], "radius" => 260, "crimeLevel" => 6],
        ["area" => "Villivakkam Station Road", "center" => [13.1100, 80.2100], "radius" => 200, "crimeLevel" => 6],
        ["area" => "Ayanavaram Bus Depot", "center" => [13.1000, 80.2350], "radius" => 220, "crimeLevel" => 6],
        ["area" => "Tambaram Sanatorium", "center" => [12.9300, 80.1200], "radius" => 240, "crimeLevel" => 5],
        ["area" => "Thirumullaivoyal", "center" => [13.1300, 80.1300], "radius" => 250, "crimeLevel" => 5],
        ["area" => "Avadi Camp Road", "center" => [13.1150, 80.1000], "radius" => 230, "crimeLevel" => 5],
        ["area" => "Pattabiram Main Road", "center" => [13.1200, 80.0700], "radius" => 240, "crimeLevel" => 5],
        ["area" => "Thiruninravur", "center" => [13.1200, 80.0300], "radius" => 260, "crimeLevel" => 4],
        ["area" => "Puzhal Camp", "center" => [13.1600, 80.2000], "radius" => 250, "crimeLevel" => 6],
        ["area" => "Kodungaiyur Dump Yard", "center" => [13.1350, 80.2600], "radius" => 220, "crimeLevel" => 7],
        ["area" => "Washermanpet Market", "center" => [13.1100, 80.2850], "radius" => 200, "crimeLevel" => 7],
        ["area" => "Royapuram Fishing Harbour", "center" => [13.1050, 80.2950], "radius" => 210, "crimeLevel" => 7],
        ["area" => "Chintadripet Market", "center" => [13.0750, 80.2700], "radius" => 180, "crimeLevel" => 7],
        ["area" => "Saidapet Bus Stand", "center" => [13.0200, 80.2250], "radius" => 200, "crimeLevel" => 7],
        ["area" => "Ashok Pillar", "center" => [13.0350, 80.2100], "radius" => 190, "crimeLevel" => 6],
        ["area" => "Vadapalani Junction", "center" => [13.0500, 80.2150], "radius" => 220, "crimeLevel" => 6],
        ["area" => "K.K. Nagar Main Road", "center" => [13.0400, 80.2000], "radius" => 230, "crimeLevel" => 5],
        ["area" => "Virugambakkam Market", "center" => [13.0550, 80.1950], "radius" => 200, "crimeLevel" => 5],
        ["area" => "Valasaravakkam Arcot Road", "center" => [13.0450, 80.1850], "radius" => 210, "crimeLevel" => 5],
        ["area" => "Thoraipakkam OMR", "center" => [12.9400, 80.2350], "radius" => 250, "crimeLevel" => 4],
        ["area" => "Perungudi Industrial Area", "center" => [12.9650, 80.2450], "radius" => 240, "crimeLevel" => 4],
        ["area" => "Thiruvanmiyur Beach Road", "center" => [12.9850, 80.2650], "radius" => 220, "crimeLevel" => 4],
        ["area" => "Besant Nagar 2nd Avenue", "center" => [12.9950, 80.2700], "radius" => 200, "crimeLevel" => 3],
        ["area" => "Alwarpet TTK Road", "center" => [13.0350, 80.2500], "radius" => 180, "crimeLevel" => 5],
        ["area" => "Mandaveli Market", "center" => [13.0250, 80.2600], "radius" => 170, "crimeLevel" => 5],
        ["area" => "Santhome High Road", "center" => [13.0300, 80.2750], "radius" => 190, "crimeLevel" => 5],
        ["area" => "Triplicane High Road", "center" => [13.0600, 80.2750], "radius" => 200, "crimeLevel" => 7],
        ["area" => "Chetpet Railway Station", "center" => [13.0750, 80.2450], "radius" => 180, "crimeLevel" => 6],
        ["area" => "Kilpauk Garden Road", "center" => [13.0800, 80.2350], "radius" => 190, "crimeLevel" => 4],
        ["area" => "Aminjikarai Market", "center" => [13.0700, 80.2250], "radius" => 210, "crimeLevel" => 6],
        ["area" => "Shenoy Nagar Park", "center" => [13.0750, 80.2300], "radius" => 200, "crimeLevel" => 4],
        ["area" => "Choolaimedu High Road", "center" => [13.0650, 80.2250], "radius" => 200, "crimeLevel" => 6],
        ["area" => "Arumbakkam Metro", "center" => [13.0650, 80.2050], "radius" => 220, "crimeLevel" => 5]
    ];
}

function getPoliceStations() {
    return [
        ["name" => "T. Nagar Police Station", "center" => [13.0399, 80.2344], "phone" => "044-24340000", "address" => "30, Venkatanarayana Rd, T. Nagar"],
        ["name" => "Adyar Police Station", "center" => [13.0045, 80.2571], "phone" => "044-24410000", "address" => "Lattice Bridge Rd, Adyar"],
        ["name" => "Anna Nagar Police Station", "center" => [13.0858, 80.2139], "phone" => "044-26214444", "address" => "2nd Avenue, Anna Nagar"],
        ["name" => "Selaiyur Police Station", "center" => [12.9196, 80.1382], "phone" => "044-22293100", "address" => "Selaiyur, Chennai, Tamil Nadu 600073"],
        ["name" => "Mylapore Police Station", "center" => [13.0350, 80.2680], "phone" => "044-23452500", "address" => "Mylapore Luz Church Road"],
        ["name" => "Velachery Police Station", "center" => [12.9750, 80.2200], "phone" => "044-22430000", "address" => "Velachery Main Road"],
        ["name" => "Egmore Police Station", "center" => [13.0740, 80.2520], "phone" => "044-28194500", "address" => "Egmore High Road"],
        ["name" => "Royapettah Police Station", "center" => [13.0540, 80.2640], "phone" => "044-28511000", "address" => "Royapettah High Road"],
        ["name" => "Triplicane Police Station", "center" => [13.0580, 80.2750], "phone" => "044-28441000", "address" => "Triplicane High Road"],
        ["name" => "Guindy Police Station", "center" => [13.0080, 80.2210], "phone" => "044-22340000", "address" => "Guindy Industrial Estate"],
        ["name" => "Kodambakkam Police Station", "center" => [13.0500, 80.2250], "phone" => "044-24740000", "address" => "Arcot Road, Kodambakkam"],
        ["name" => "Nungambakkam Police Station", "center" => [13.0600, 80.2450], "phone" => "044-28270000", "address" => "Valluvar Kottam High Road"],
        ["name" => "Porur Police Station", "center" => [13.0350, 80.1550], "phone" => "044-24760000", "address" => "Mount Poonamallee Road"],
        ["name" => "Saidapet Police Station", "center" => [13.0200, 80.2250], "phone" => "044-24350000", "address" => "Saidapet Bus Stand"],
        ["name" => "Ashok Nagar Police Station", "center" => [13.0350, 80.2100], "phone" => "044-23630000", "address" => "4th Avenue, Ashok Nagar"],
        ["name" => "Vadapalani Police Station", "center" => [13.0500, 80.2150], "phone" => "044-23620000", "address" => "100 Feet Road, Vadapalani"],
        ["name" => "K.K. Nagar Police Station", "center" => [13.0400, 80.2000], "phone" => "044-23640000", "address" => "PT Rajan Salai"],
        ["name" => "Chromepet Police Station", "center" => [12.9510, 80.1450], "phone" => "044-22410000", "address" => "GST Road, Chromepet"],
        ["name" => "Tambaram Police Station", "center" => [12.9250, 80.1000], "phone" => "044-22260000", "address" => "Tambaram Main Road"],
        ["name" => "Pallavaram Police Station", "center" => [12.9700, 80.1500], "phone" => "044-22640000", "address" => "Pallavaram Flyover"],
        ["name" => "Perambur Police Station", "center" => [13.1050, 80.2450], "phone" => "044-25500000", "address" => "Paper Mills Road"],
        ["name" => "Washermanpet Police Station", "center" => [13.1100, 80.2850], "phone" => "044-25210000", "address" => "Old Washermanpet"],
        ["name" => "Royapuram Police Station", "center" => [13.1050, 80.2950], "phone" => "044-25220000", "address" => "Fishing Harbour Road"],
        ["name" => "Chintadripet Police Station", "center" => [13.0750, 80.2700], "phone" => "044-28450000", "address" => "Chintadripet Market"],
        ["name" => "Kilpauk Police Station", "center" => [13.0800, 80.2350], "phone" => "044-26440000", "address" => "New Avadi Road"],
        ["name" => "Aminjikarai Police Station", "center" => [13.0700, 80.2250], "phone" => "044-26630000", "address" => "Nelson Manickam Road"],
        ["name" => "Shenoy Nagar Police Station", "center" => [13.0750, 80.2300], "phone" => "044-26180000", "address" => "Pulla Avenue"],
        ["name" => "Choolaimedu Police Station", "center" => [13.0650, 80.2250], "phone" => "044-28340000", "address" => "Choolaimedu High Road"],
        ["name" => "Arumbakkam Police Station", "center" => [13.0650, 80.2050], "phone" => "044-23650000", "address" => "PH Road, Arumbakkam"],
        ["name" => "Thiruvanmiyur Police Station", "center" => [12.9850, 80.2650], "phone" => "044-24460000", "address" => "ECR, Thiruvanmiyur"],
        ["name" => "Besant Nagar Police Station", "center" => [12.9950, 80.2700], "phone" => "044-24470000", "address" => "2nd Avenue, Besant Nagar"],
        ["name" => "Alwarpet Police Station", "center" => [13.0350, 80.2500], "phone" => "044-24320000", "address" => "TTK Road, Alwarpet"],
        ["name" => "Mandaveli Police Station", "center" => [13.0250, 80.2600], "phone" => "044-24640000", "address" => "Mandaveli Market"],
        ["name" => "Santhome Police Station", "center" => [13.0300, 80.2750], "phone" => "044-24980000", "address" => "Santhome High Road"],
        ["name" => "Chetpet Police Station", "center" => [13.0750, 80.2450], "phone" => "044-28360000", "address" => "McNichols Road"],
        ["name" => "Madhavaram Police Station", "center" => [13.1500, 80.2400], "phone" => "044-25590000", "address" => "Madhavaram Milk Colony"],
        ["name" => "Manali Police Station", "center" => [13.1700, 80.2700], "phone" => "044-25940000", "address" => "Manali New Town"],
        ["name" => "Tondiarpet Police Station", "center" => [13.1300, 80.2900], "phone" => "044-25950000", "address" => "Tondiarpet High Road"],
        ["name" => "Thiruvottiyur Police Station", "center" => [13.1600, 80.3000], "phone" => "044-25960000", "address" => "Thiruvottiyur High Road"],
        ["name" => "Ambattur Police Station", "center" => [13.0950, 80.1650], "phone" => "044-26250000", "address" => "Ambattur Industrial Estate"],
        ["name" => "Mogappair Police Station", "center" => [13.0830, 80.1750], "phone" => "044-26560000", "address" => "Mogappair East"],
        ["name" => "Sholinganallur Police Station", "center" => [12.9000, 80.2280], "phone" => "044-24500000", "address" => "Sholinganallur Junction"],
        ["name" => "Avadi Police Station", "center" => [13.1150, 80.1000], "phone" => "044-26550000", "address" => "Avadi Camp Road"],
        ["name" => "Pattabiram Police Station", "center" => [13.1200, 80.0700], "phone" => "044-26840000", "address" => "Pattabiram Main Road"],
        ["name" => "Puzhal Police Station", "center" => [13.1600, 80.2000], "phone" => "044-26590000", "address" => "Puzhal Camp"],
        ["name" => "Kodungaiyur Police Station", "center" => [13.1350, 80.2600], "phone" => "044-25570000", "address" => "Kodungaiyur Dump Yard"],
        ["name" => "Koyambedu Police Station", "center" => [13.0700, 80.1950], "phone" => "044-24790000", "address" => "Koyambedu Market"]
    ];
}

function handleApiRequest() {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    if ($path === '/api/areas') {
        header('Content-Type: application/json');
        echo json_encode(getAreaCircles());
        return;
    }
    
    if ($path === '/api/police-stations') {
        header('Content-Type: application/json');
        echo json_encode(getPoliceStations());
        return;
    }
    
    if ($path === '/api/nearest-police-station' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $lat = $data['latitude'] ?? null;
        $lng = $data['longitude'] ?? null;
        
        if ($lat === null || $lng === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Latitude and longitude are required']);
            return;
        }
        
        $nearest = null;
        $minDistance = PHP_FLOAT_MAX;
        $stations = getPoliceStations();
        
        foreach ($stations as $station) {
            $distance = calculateDistance(
                $lat, $lng,
                $station['center'][0], $station['center'][1]
            );
            
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearest = $station;
            }
        }
        
        if ($nearest) {
            echo json_encode([
                "station" => $nearest,
                "distance" => $minDistance
            ]);
        } else {
            echo json_encode(["error" => "No police stations found"]);
        }
        return;
    }
    
    if ($path === '/api/check-location' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $lat = $data['latitude'] ?? null;
        $lng = $data['longitude'] ?? null;
        
        if ($lat === null || $lng === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Latitude and longitude are required']);
            return;
        }
        
        $isDay = isDayTime();
        $areas = getAreaCircles();
        
        foreach ($areas as $area) {
            if (pointInCircle([$lat, $lng], $area['center'], $area['radius'])) {
                $crimeLevel = $area['crimeLevel'];
                $message = '';
                
                if ($isDay) {
                    if ($crimeLevel >= 7) {
                        $message = "Attention - {$area['area']}\nCrime Level: {$crimeLevel}/10\nHigh crime area! Travel in groups and stay vigilant during daytime.";
                    } else if ($crimeLevel >= 4) {
                        $message = "Notice - {$area['area']}\nCrime Level: {$crimeLevel}/10\nModerate crime area. Be cautious of your belongings.";
                    } else {
                        $message = "Info - {$area['area']}\nCrime Level: {$crimeLevel}/10\nRelatively safe during daytime. Normal precautions advised.";
                    }
                } else {
                    if ($crimeLevel >= 7) {
                        $message = "WARNING - {$area['area']}\nCrime Level: {$crimeLevel}/10\nDangerous at night! Beware of thieves and suspicious activities. Avoid if possible.";
                    } else if ($crimeLevel >= 4) {
                        $message = "Alert - {$area['area']}\nCrime Level: {$crimeLevel}/10\nNight time caution advised. Watch for pickpockets and stay in well-lit areas.";
                    } else {
                        $message = "Notice - {$area['area']}\nCrime Level: {$crimeLevel}/10\nGenerally safe at night. Stay aware of surroundings.";
                    }
                }
                
                $timezone = new DateTimeZone('Asia/Kolkata');
                $now = new DateTime('now', $timezone);
                
                echo json_encode([
                    "inDangerZone" => true,
                    "area" => $area['area'],
                    "crimeLevel" => $crimeLevel,
                    "message" => $message,
                    "isDayTime" => $isDay,
                    "timestamp" => $now->format("Y-m-d h:i:s A T")
                ]);
                return;
            }
        }
        
        echo json_encode(["inDangerZone" => false]);
        return;
    }
    
    if ($path === '/api/safety-stats') {
        $areas = getAreaCircles();
        $crimeLevels = array_column($areas, 'crimeLevel');
        $totalAreas = count($areas);
        
        $stats = [
            'total_areas' => $totalAreas,
            'average_crime_level' => round(array_sum($crimeLevels) / $totalAreas, 2),
            'max_crime_level' => max($crimeLevels),
            'min_crime_level' => min($crimeLevels),
            'high_risk_areas' => count(array_filter($crimeLevels, function($x) { return $x >= 7; })),
            'medium_risk_areas' => count(array_filter($crimeLevels, function($x) { return $x >= 4 && $x < 7; })),
            'low_risk_areas' => count(array_filter($crimeLevels, function($x) { return $x < 4; }))
        ];
        
        header('Content-Type: application/json');
        echo json_encode($stats);
        return;
    }
    
    if ($path === '/api/health') {
        $timezone = new DateTimeZone('Asia/Kolkata');
        $now = new DateTime('now', $timezone);
        echo json_encode([
            'status' => 'healthy',
            'timestamp' => $now->format("Y-m-d h:i:s A T")
        ]);
        return;
    }
    
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}

function isDayTime() {
    $hour = (int)date('G');
    return $hour >= 6 && $hour < 18; // 6 AM to 6 PM is considered day
}

function pointInCircle($point, $center, $radius) {
    $lat1 = deg2rad($point[0]);
    $lon1 = deg2rad($point[1]);
    $lat2 = deg2rad($center[0]);
    $lon2 = deg2rad($center[1]);
    
    $dlat = $lat2 - $lat1;
    $dlon = $lon2 - $lon1;
    $a = sin($dlat/2) * sin($dlat/2) + cos($lat1) * cos($lat2) * sin($dlon/2) * sin($dlon/2);
    $c = 2 * asin(sqrt($a));
    
    $R = 6371000; // Earth radius in meters
    $distance = $R * $c;
    
    return $distance <= $radius;
}

function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371000; // Earth radius in meters
    $φ1 = deg2rad($lat1);
    $φ2 = deg2rad($lat2);
    $Δφ = deg2rad($lat2 - $lat1);
    $Δλ = deg2rad($lon2 - $lon1);

    $a = sin($Δφ/2) * sin($Δφ/2) +
         cos($φ1) * cos($φ2) *
         sin($Δλ/2) * sin($Δλ/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

    return $R * $c;
}
?>
