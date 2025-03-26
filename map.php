<?php
header('Content-Type: text/html; charset=utf-8');

// Crime areas data
$area_circles = [
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
    ["area" => "Mount Road", "center" => [13.0647, 80.2642], "radius" => 250, "crimeLevel" => 7],
    ["area" => "Royapuram", "center" => [13.1045, 80.2935], "radius" => 220, "crimeLevel" => 7],
    ["area" => "Washermanpet", "center" => [13.1098, 80.2845], "radius" => 200, "crimeLevel" => 7],
    ["area" => "Triplicane", "center" => [13.0588, 80.2755], "radius" => 200, "crimeLevel" => 6],
    ["area" => "Tambaram", "center" => [12.9246, 80.1000], "radius" => 300, "crimeLevel" => 5],
    ["area" => "Chromepet", "center" => [12.9515, 80.1408], "radius" => 250, "crimeLevel" => 6],
    ["area" => "Pallavaram", "center" => [12.9679, 80.1491], "radius" => 260, "crimeLevel" => 5],
    ["area" => "Ambattur", "center" => [13.0983, 80.1622], "radius" => 300, "crimeLevel" => 4],
    ["area" => "Ashok Nagar", "center" => [13.0352, 80.2095], "radius" => 220, "crimeLevel" => 5],
    ["area" => "K.K. Nagar", "center" => [13.0400, 80.2000], "radius" => 230, "crimeLevel" => 5],
    ["area" => "Vadapalani", "center" => [13.0500, 80.2150], "radius" => 220, "crimeLevel" => 6],
    ["area" => "Saidapet", "center" => [13.0213, 80.2275], "radius" => 200, "crimeLevel" => 7],
    ["area" => "Koyambedu", "center" => [13.0692, 80.1948], "radius" => 300, "crimeLevel" => 6],
    ["area" => "Thiruvanmiyur", "center" => [12.9830, 80.2595], "radius" => 240, "crimeLevel" => 4],
    ["area" => "Besant Nagar", "center" => [12.9965, 80.2670], "radius" => 200, "crimeLevel" => 3],
    ["area" => "Alwarpet", "center" => [13.0345, 80.2520], "radius" => 180, "crimeLevel" => 5],
    ["area" => "Mandaveli", "center" => [13.0278, 80.2610], "radius" => 170, "crimeLevel" => 5],
    ["area" => "Santhome", "center" => [13.0315, 80.2780], "radius" => 190, "crimeLevel" => 5],
    ["area" => "Perambur", "center" => [13.1075, 80.2445], "radius" => 250, "crimeLevel" => 6],
    ["area" => "Ayanavaram", "center" => [13.0990, 80.2330], "radius" => 220, "crimeLevel" => 6],
    ["area" => "Kilpauk", "center" => [13.0778, 80.2410], "radius" => 200, "crimeLevel" => 5],
    ["area" => "Chetpet", "center" => [13.0715, 80.2415], "radius" => 180, "crimeLevel" => 6],
    ["area" => "Madhavaram", "center" => [13.1480, 80.2310], "radius" => 300, "crimeLevel" => 5],
    ["area" => "Manali", "center" => [13.1667, 80.2670], "radius" => 260, "crimeLevel" => 6],
    ["area" => "Tondiarpet", "center" => [13.1265, 80.2880], "radius" => 230, "crimeLevel" => 7],
    ["area" => "Thiruvottiyur", "center" => [13.1580, 80.3010], "radius" => 250, "crimeLevel" => 6],
    ["area" => "Sholinganallur", "center" => [12.8970, 80.2275], "radius" => 280, "crimeLevel" => 4],
    ["area" => "OMR (Rajiv Gandhi Salai)", "center" => [12.9300, 80.2300], "radius" => 300, "crimeLevel" => 4],
    ["area" => "ECR (East Coast Road)", "center" => [12.9500, 80.2550], "radius" => 280, "crimeLevel" => 4],
    ["area" => "Medavakkam", "center" => [12.9170, 80.1920], "radius" => 230, "crimeLevel" => 5],
    ["area" => "Poonamallee", "center" => [13.0470, 80.0945], "radius" => 300, "crimeLevel" => 5],
    ["area" => "Avadi", "center" => [13.1145, 80.1010], "radius" => 280, "crimeLevel" => 5],
    ["area" => "Mogappair", "center" => [13.0835, 80.1750], "radius" => 220, "crimeLevel" => 4],
    ["area" => "Kolathur", "center" => [13.1245, 80.2020], "radius" => 250, "crimeLevel" => 6],
    ["area" => "Vyasarpadi", "center" => [13.1175, 80.2590], "radius" => 220, "crimeLevel" => 7],
    ["area" => "Korukkupet", "center" => [13.1180, 80.2780], "radius" => 210, "crimeLevel" => 7],
    ["area" => "Purasawalkam", "center" => [13.0875, 80.2550], "radius" => 200, "crimeLevel" => 6],
    ["area" => "Choolaimedu", "center" => [13.0615, 80.2250], "radius" => 200, "crimeLevel" => 6],
    ["area" => "Aminjikarai", "center" => [13.0695, 80.2245], "radius" => 210, "crimeLevel" => 6],
    ["area" => "Shenoy Nagar", "center" => [13.0760, 80.2300], "radius" => 200, "crimeLevel" => 4],
    ["area" => "Arumbakkam", "center" => [13.0650, 80.2050], "radius" => 220, "crimeLevel" => 5],
    ["area" => "Red Hills", "center" => [13.1879, 80.1989], "radius" => 300, "crimeLevel" => 5],
    ["area" => "Ennore", "center" => [13.2146, 80.3203], "radius" => 250, "crimeLevel" => 6],
    ["area" => "Minjur", "center" => [13.2788, 80.2588], "radius" => 280, "crimeLevel" => 5],
    ["area" => "Sriperumbudur", "center" => [12.9677, 79.9419], "radius" => 350, "crimeLevel" => 4],
    ["area" => "Kelambakkam", "center" => [12.7963, 80.2220], "radius" => 270, "crimeLevel" => 3],
    ["area" => "Mamallapuram", "center" => [12.6208, 80.1945], "radius" => 300, "crimeLevel" => 3],
    ["area" => "Kovalam", "center" => [12.7898, 80.2512], "radius" => 240, "crimeLevel" => 4],
    ["area" => "Navalur", "center" => [12.8460, 80.2262], "radius" => 260, "crimeLevel" => 3],
    ["area" => "Siruseri", "center" => [12.8372, 80.2028], "radius" => 280, "crimeLevel" => 3],
    ["area" => "Kattankulathur", "center" => [12.8290, 80.0428], "radius" => 300, "crimeLevel" => 4],
    ["area" => "Potheri", "center" => [12.8230, 80.0420], "radius" => 250, "crimeLevel" => 4],
    ["area" => "Thiruporur", "center" => [12.7305, 80.1890], "radius" => 290, "crimeLevel" => 4],
    ["area" => "Uthandi", "center" => [12.8705, 80.2520], "radius" => 230, "crimeLevel" => 3],
    ["area" => "Ponneri", "center" => [13.3378, 80.1949], "radius" => 310, "crimeLevel" => 5],
    ["area" => "Villivakkam", "center" => [13.1080, 80.2080], "radius" => 200, "crimeLevel" => 6],
    ["area" => "Thoraipakkam", "center" => [12.9410, 80.2350], "radius" => 250, "crimeLevel" => 4],
    ["area" => "Perungudi", "center" => [12.9650, 80.2450], "radius" => 240, "crimeLevel" => 4],
    ["area" => "Selaiyur", "center" => [12.9068, 80.1425], "radius" => 230, "crimeLevel" => 5],
    ["area" => "Pallikaranai", "center" => [12.9345, 80.2130], "radius" => 260, "crimeLevel" => 5],
    ["area" => "Madipakkam", "center" => [12.9650, 80.2090], "radius" => 220, "crimeLevel" => 5],
    ["area" => "Nanganallur", "center" => [12.9770, 80.1880], "radius" => 200, "crimeLevel" => 5],
    ["area" => "Adambakkam", "center" => [12.9920, 80.2040], "radius" => 210, "crimeLevel" => 6],
    ["area" => "Virugambakkam", "center" => [13.0550, 80.1950], "radius" => 200, "crimeLevel" => 5],
    ["area" => "Valasaravakkam", "center" => [13.0450, 80.1850], "radius" => 210, "crimeLevel" => 5]
];

// Police stations data
$police_stations = [
    ["name" => "T. Nagar Police Station", "center" => [13.0399, 80.2344], "phone" => "044-24340000", "address" => "Venkatanarayana Rd"],
    ["name" => "Adyar Police Station", "center" => [13.0045, 80.2571], "phone" => "044-24410000", "address" => "Lattice Bridge Rd"],
    ["name" => "Mylapore Police Station", "center" => [13.0350, 80.2680], "phone" => "044-23452500", "address" => "Luz Church Road"],
    ["name" => "Anna Nagar Police Station", "center" => [13.0858, 80.2139], "phone" => "044-26214444", "address" => "2nd Avenue"],
    ["name" => "Velachery Police Station", "center" => [12.9750, 80.2200], "phone" => "044-22430000", "address" => "Velachery Main Rd"],
    ["name" => "Guindy Police Station", "center" => [13.0080, 80.2210], "phone" => "044-22340000", "address" => "Guindy Industrial Estate"],
    ["name" => "Egmore Police Station", "center" => [13.0740, 80.2520], "phone" => "044-28194500", "address" => "Egmore High Rd"],
    ["name" => "Porur Police Station", "center" => [13.0350, 80.1550], "phone" => "044-24760000", "address" => "Mount Poonamallee Rd"],
    ["name" => "Nungambakkam Police Station", "center" => [13.0600, 80.2450], "phone" => "044-28270000", "address" => "Valluvar Kottam Rd"],
    ["name" => "Kodambakkam Police Station", "center" => [13.0500, 80.2250], "phone" => "044-24740000", "address" => "Arcot Road"],
    ["name" => "Royapuram Police Station", "center" => [13.1050, 80.2950], "phone" => "044-25220000", "address" => "Fishing Harbour Rd"],
    ["name" => "Washermanpet Police Station", "center" => [13.1100, 80.2850], "phone" => "044-25210000", "address" => "Old Washermanpet"],
    ["name" => "Triplicane Police Station", "center" => [13.0580, 80.2750], "phone" => "044-28441000", "address" => "Triplicane High Rd"],
    ["name" => "Tambaram Police Station", "center" => [12.9250, 80.1000], "phone" => "044-22260000", "address" => "Tambaram Main Rd"],
    ["name" => "Chromepet Police Station", "center" => [12.9510, 80.1450], "phone" => "044-22410000", "address" => "GST Road"],
    ["name" => "Pallavaram Police Station", "center" => [12.9700, 80.1500], "phone" => "044-22640000", "address" => "Pallavaram Flyover"],
    ["name" => "Ambattur Police Station", "center" => [13.0950, 80.1650], "phone" => "044-26250000", "address" => "Ambattur Industrial Estate"],
    ["name" => "Ashok Nagar Police Station", "center" => [13.0350, 80.2100], "phone" => "044-23630000", "address" => "4th Avenue"],
    ["name" => "K.K. Nagar Police Station", "center" => [13.0400, 80.2000], "phone" => "044-23640000", "address" => "PT Rajan Salai"],
    ["name" => "Vadapalani Police Station", "center" => [13.0500, 80.2150], "phone" => "044-23620000", "address" => "100 Feet Road"],
    ["name" => "Saidapet Police Station", "center" => [13.0200, 80.2250], "phone" => "044-24350000", "address" => "Saidapet Bus Stand"],
    ["name" => "Koyambedu Police Station", "center" => [13.0700, 80.1950], "phone" => "044-24790000", "address" => "Koyambedu Market"],
    ["name" => "Thiruvanmiyur Police Station", "center" => [12.9850, 80.2650], "phone" => "044-24460000", "address" => "ECR"],
    ["name" => "Besant Nagar Police Station", "center" => [12.9950, 80.2700], "phone" => "044-24470000", "address" => "2nd Avenue"],
    ["name" => "Alwarpet Police Station", "center" => [13.0350, 80.2500], "phone" => "044-24320000", "address" => "TTK Road"],
    ["name" => "Perambur Police Station", "center" => [13.1050, 80.2450], "phone" => "044-25500000", "address" => "Paper Mills Road"],
    ["name" => "Ayanavaram Police Station", "center" => [13.0990, 80.2350], "phone" => "044-26440000", "address" => "Ayanavaram Bus Depot"],
    ["name" => "Kilpauk Police Station", "center" => [13.0800, 80.2350], "phone" => "044-26440000", "address" => "New Avadi Road"],
    ["name" => "Madhavaram Police Station", "center" => [13.1500, 80.2400], "phone" => "044-25590000", "address" => "Milk Colony"],
    ["name" => "Manali Police Station", "center" => [13.1700, 80.2700], "phone" => "044-25940000", "address" => "Manali New Town"],
    ["name" => "Tondiarpet Police Station", "center" => [13.1300, 80.2900], "phone" => "044-25950000", "address" => "Tondiarpet High Rd"],
    ["name" => "Thiruvottiyur Police Station", "center" => [13.1600, 80.3000], "phone" => "044-25960000", "address" => "Thiruvottiyur High Rd"],
    ["name" => "Sholinganallur Police Station", "center" => [12.9000, 80.2280], "phone" => "044-24500000", "address" => "Sholinganallur Junction"],
    ["name" => "Avadi Police Station", "center" => [13.1150, 80.1000], "phone" => "044-26550000", "address" => "Avadi Camp Road"],
    ["name" => "Mogappair Police Station", "center" => [13.0830, 80.1750], "phone" => "044-26560000", "address" => "Mogappair East"]
];

// Function to calculate distance to nearest police station
function get_nearest_police_distance($area_center) {
    global $police_stations;
    $min_distance = INF;
    foreach ($police_stations as $station) {
        $station_lat = $station['center'][0];
        $station_lng = $station['center'][1];
        $area_lat = $area_center[0];
        $area_lng = $area_center[1];
        $distance = sqrt(pow($area_lat - $station_lat, 2) + pow($area_lng - $station_lng, 2)) * 111000;
        if ($distance < $min_distance) {
            $min_distance = $distance;
        }
    }
    return $min_distance;
}

// Crime prediction function
function predict_crime_trend($current_level, $area_center, $days_ahead = 7) {
    $distance_to_police = get_nearest_police_distance($area_center);
    
    if ($distance_to_police <= 500) {
        $base_trend = -0.15;
        $trend = "decreasing";
    } else {
        $base_trend = 0.1;
        $trend = "increasing";
    }
    
    $daily_variation = rand(-20, 20) / 100;
    $predicted_level = $current_level + ($base_trend * $days_ahead) + $daily_variation;
    
    $predicted_level = max(0, min(10, $predicted_level));
    
    return [
        "current" => $current_level,
        "predicted" => round($predicted_level, 1),
        "trend" => $trend,
        "days_ahead" => $days_ahead,
        "distance_to_police" => round($distance_to_police / 1000, 2)
    ];
}

// Handle API requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    switch ($_GET['action']) {
        case 'time':
            $timezone = new DateTimeZone('Asia/Kolkata');
            $current_time = new DateTime('now', $timezone);
            $is_day = $current_time->format('H') >= 6 && $current_time->format('H') < 18;
            echo json_encode([
                "timestamp" => $current_time->format('Y-m-d H:i:s T'),
                "isDayTime" => $is_day,
                "dayOrNight" => $is_day ? "Day" : "Night"
            ]);
            exit;
            
        case 'areas':
            echo json_encode($area_circles);
            exit;
            
        case 'police-stations':
            echo json_encode($police_stations);
            exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    
    switch ($_GET['action']) {
        case 'nearest-police-station':
            $lat = $data['latitude'] ?? null;
            $lng = $data['longitude'] ?? null;
            
            if ($lat === null || $lng === null) {
                echo json_encode(['error' => 'Latitude and longitude are required']);
                exit;
            }
            
            $nearest = null;
            $min_distance = INF;
            
            foreach ($police_stations as $station) {
                $station_lat = $station['center'][0];
                $station_lng = $station['center'][1];
                $distance = sqrt(pow($lat - $station_lat, 2) + pow($lng - $station_lng, 2)) * 111000;
                if ($distance < $min_distance) {
                    $min_distance = $distance;
                    $nearest = $station;
                }
            }
            
            if ($nearest) {
                echo json_encode(["station" => $nearest, "distance" => round($min_distance, 2)]);
            } else {
                echo json_encode(["error" => "No police stations found"]);
            }
            exit;
            
        case 'check-location':
            $lat = $data['latitude'] ?? null;
            $lng = $data['longitude'] ?? null;
            
            if ($lat === null || $lng === null) {
                echo json_encode(['error' => 'Latitude and longitude are required']);
                exit;
            }
            
            $timezone = new DateTimeZone('Asia/Kolkata');
            $current_time = new DateTime('now', $timezone);
            $is_day = $current_time->format('H') >= 6 && $current_time->format('H') < 18;
            
            foreach ($area_circles as $area) {
                $area_lat = $area['center'][0];
                $area_lng = $area['center'][1];
                $distance = sqrt(pow($lat - $area_lat, 2) + pow($lng - $area_lng, 2)) * 111000;
                if ($distance <= $area['radius']) {
                    $message = $area['area'] . " - Crime Level: " . $area['crimeLevel'] . "/10\n" . 
                              ($area['crimeLevel'] >= 7 ? "Stay vigilant!" : "Be cautious.");
                    echo json_encode([
                        "inDangerZone" => true,
                        "area" => $area['area'],
                        "crimeLevel" => $area['crimeLevel'],
                        "message" => $message,
                        "isDayTime" => $is_day
                    ]);
                    exit;
                }
            }
            echo json_encode(["inDangerZone" => false]);
            exit;
            
        case 'predict-crime':
            $lat = $data['latitude'] ?? null;
            $lng = $data['longitude'] ?? null;
            
            if ($lat === null || $lng === null) {
                echo json_encode(['error' => 'Latitude and longitude are required']);
                exit;
            }
            
            $timezone = new DateTimeZone('Asia/Kolkata');
            $current_time = new DateTime('now', $timezone);
            $is_day = $current_time->format('H') >= 6 && $current_time->format('H') < 18;
            $timestamp = $current_time->format('Y-m-d H:i:s T');
            
            foreach ($area_circles as $area) {
                $area_lat = $area['center'][0];
                $area_lng = $area['center'][1];
                $distance = sqrt(pow($lat - $area_lat, 2) + pow($lng - $area_lng, 2)) * 111000;
                if ($distance <= $area['radius']) {
                    $prediction = predict_crime_trend($area['crimeLevel'], $area['center']);
                    echo json_encode([
                        "area" => $area['area'],
                        "prediction" => $prediction,
                        "message" => "📢 PUBLIC SAFETY ANNOUNCEMENT 📢<br>Area: " . $area['area'] . 
                                    "<br>Current Crime Level: " . $prediction['current'] . "/10<br>" .
                                    "Predicted Crime Level in " . $prediction['days_ahead'] . " days: " . 
                                    $prediction['predicted'] . "/10<br>Trend: " . ucfirst($prediction['trend']) . 
                                    "<br>Distance to Nearest Police Station: " . $prediction['distance_to_police'] . 
                                    " km<br>Time: " . $timestamp . "<br>Day/Night: " . ($is_day ? "Day" : "Night")
                    ]);
                    exit;
                }
            }
            echo json_encode(["error" => "Location not in any defined area"]);
            exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chennai Crime Map</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <style>
        body { margin: 0; padding: 0; }
        #map { height: 100vh; width: 100%; }
        .police-button, .predict-button, .reset-button {
            position: absolute;
            bottom: 20px;
            z-index: 1000;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .police-button {
            left: 20px;
            background-color: #1a237e;
        }
        .predict-button {
            left: 150px;
            background-color: #00695c;
        }
        .reset-button {
            left: 280px;
            background-color: #d32f2f;
        }
        .police-button:hover { background-color: #283593; }
        .predict-button:hover { background-color: #00897b; }
        .reset-button:hover { background-color: #f44336; }
        .leaflet-popup-content {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .leaflet-popup-content .announcement {
            background-color: #ffeb3b;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #f44336;
            text-align: center;
            font-weight: bold;
        }
        .time-display {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .time-display .day-night {
            font-weight: bold;
            color: #1a237e;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <div id="time-display" class="time-display">
        <div id="timestamp">Loading...</div>
        <div id="day-night" class="day-night">Loading...</div>
    </div>
    <button id="find-police" class="police-button">Navigate to Nearest Police</button>
    <button id="predict-crime" class="predict-button">Predict Crime Trend</button>
    <button id="reset-position" class="reset-button">Reset Position</button>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script>
        // Initialize the map centered on Chennai
        const map = L.map('map').setView([13.0827, 80.2707], 11);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Function to get color based on crime level
        function getColor(crimeLevel) {
            return crimeLevel >= 7 ? '#BD0026' : 
                   crimeLevel >= 4 ? '#FD8D3C' : '#FED976';
        }

        // Function to load and display all crime areas
        function loadCrimeAreas() {
            fetch('?action=areas')
                .then(response => response.json())
                .then(areas => {
                    areas.forEach(area => {
                        // Create a circle for each crime area
                        const circle = L.circle(area.center, {
                            color: getColor(area.crimeLevel),
                            fillColor: getColor(area.crimeLevel),
                            fillOpacity: 0.5,
                            radius: area.radius
                        }).addTo(map);
                        
                        // Add tooltip with area name and crime level
                        circle.bindTooltip(
                            `<strong>${area.area}</strong><br>Crime Level: ${area.crimeLevel}/10`,
                            { permanent: false, direction: 'top' }
                        );
                        
                        // Add click event to show more details
                        circle.on('click', function(e) {
                            fetch('?action=predict-crime', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ 
                                    latitude: area.center[0], 
                                    longitude: area.center[1] 
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message) {
                                    L.popup()
                                        .setLatLng(area.center)
                                        .setContent(`<div class="announcement">${data.message}</div>`)
                                        .openOn(map);
                                }
                            });
                        });
                    });
                })
                .catch(error => console.error('Error loading crime areas:', error));
        }

        // Function to load and display all police stations
        function loadPoliceStations() {
            fetch('?action=police-stations')
                .then(response => response.json())
                .then(stations => {
                    const policeIcon = L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/73/73371.png',
                        iconSize: [32, 32],
                        iconAnchor: [16, 16]
                    });
                    
                    stations.forEach(station => {
                        L.marker(station.center, { icon: policeIcon })
                            .addTo(map)
                            .bindPopup(`
                                <strong>${station.name}</strong><br>
                                ${station.address}<br>
                                Phone: ${station.phone}
                            `);
                    });
                })
                .catch(error => console.error('Error loading police stations:', error));
        }

        // Function to update time display
        function updateTimeDisplay() {
            fetch('?action=time')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('timestamp').textContent = `Time: ${data.timestamp}`;
                    document.getElementById('day-night').textContent = `Day/Night: ${data.dayOrNight}`;
                })
                .catch(error => {
                    console.error('Error fetching time:', error);
                    document.getElementById('timestamp').textContent = 'Time: Error';
                    document.getElementById('day-night').textContent = 'Day/Night: Error';
                });
        }

        // Initialize user marker
        const userIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/1673/1673221.png',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });

        const initialPosition = { lat: 13.0827, lng: 80.2707 };
        const userMarker = L.marker([initialPosition.lat, initialPosition.lng], { 
            icon: userIcon,
            draggable: true
        }).addTo(map).bindPopup('You are here').openPopup();

        let targetMarker = null;
        let currentPath = null;
        let movementInterval = null;

        // Function to calculate distance between two points
        function calculateDistance(start, end) {
            return Math.sqrt(
                Math.pow(end.lat - start.lat, 2) + 
                Math.pow(end.lng - start.lng, 2)
            );
        }

        // Function to simulate movement between points
        function startRealTimeMovement(startLatLng, endLatLng) {
            if (movementInterval) {
                clearInterval(movementInterval);
            }

            if (currentPath) {
                map.removeLayer(currentPath);
            }

            const start = { lat: startLatLng.lat, lng: startLatLng.lng };
            const end = { lat: endLatLng.lat, lng: endLatLng.lng };

            // Draw initial path
            currentPath = L.polyline([start, end], { color: 'blue', weight: 4 }).addTo(map);

            const totalDistance = calculateDistance(start, end);
            const speed = 0.00001;
            const updateInterval = 50;

            let currentLat = start.lat;
            let currentLng = start.lng;

            const deltaLat = (end.lat - start.lat);
            const deltaLng = (end.lng - start.lng);

            const distancePerStep = speed;
            const steps = Math.ceil(totalDistance / distancePerStep);
            const stepLat = deltaLat / steps;
            const stepLng = deltaLng / steps;

            movementInterval = setInterval(() => {
                const remainingDistance = calculateDistance(
                    { lat: currentLat, lng: currentLng },
                    end
                );

                if (remainingDistance < 0.0001) {
                    clearInterval(movementInterval);
                    userMarker.setLatLng(end);
                    userMarker.bindPopup('You have arrived!').openPopup();
                    return;
                }

                currentLat += stepLat;
                currentLng += stepLng;

                userMarker.setLatLng([currentLat, currentLng]);
                map.panTo([currentLat, currentLng]);

                // Update path
                if (currentPath) {
                    map.removeLayer(currentPath);
                }
                currentPath = L.polyline([
                    [start.lat, start.lng],
                    [currentLat, currentLng],
                    [end.lat, end.lng]
                ], { color: 'blue', weight: 4 }).addTo(map);
            }, updateInterval);
        }

        // Map click event handler
        map.on('click', function(e) {
            userMarker.setLatLng(e.latlng);
            
            // Check location safety
            fetch('?action=check-location', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    latitude: e.latlng.lat, 
                    longitude: e.latlng.lng 
                })
            })
            .then(response => response.json())
            .then(data => {
                userMarker.bindPopup(
                    data.inDangerZone ? data.message : 'Safe Zone'
                ).openPopup();
            });

            // Remove previous target marker
            if (targetMarker) {
                map.removeLayer(targetMarker);
            }

            // Add new target marker
            targetMarker = L.marker(e.latlng, {
                icon: L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                    iconSize: [32, 32],
                    iconAnchor: [16, 16]
                })
            }).addTo(map).bindPopup('Target Location');

            // Start moving to target
            startRealTimeMovement(userMarker.getLatLng(), e.latlng);
        });

        // Find nearest police station button
        document.getElementById('find-police').addEventListener('click', function() {
            const userLatLng = userMarker.getLatLng();
            
            fetch('?action=nearest-police-station', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    latitude: userLatLng.lat, 
                    longitude: userLatLng.lng 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.station) {
                    const distanceKm = (data.distance / 1000).toFixed(2);
                    
                    // Show station info
                    L.popup()
                        .setLatLng(data.station.center)
                        .setContent(`
                            <strong>${data.station.name}</strong><br>
                            Distance: ${distanceKm} km
                        `)
                        .openOn(map);

                    // Remove previous target
                    if (targetMarker) {
                        map.removeLayer(targetMarker);
                    }

                    // Add police station as target
                    const policeIcon = L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/73/73371.png',
                        iconSize: [32, 32],
                        iconAnchor: [16, 16]
                    });
                    
                    targetMarker = L.marker(data.station.center, {
                        icon: policeIcon
                    }).addTo(map).bindPopup(`
                        <strong>${data.station.name}</strong><br>
                        Target Location
                    `);

                    // Start moving to police station
                    startRealTimeMovement(userLatLng, { 
                        lat: data.station.center[0], 
                        lng: data.station.center[1] 
                    });
                } else {
                    alert('No police station found');
                }
            });
        });

        // Predict crime button
        document.getElementById('predict-crime').addEventListener('click', function() {
            const userLatLng = userMarker.getLatLng();
            
            fetch('?action=predict-crime', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    latitude: userLatLng.lat, 
                    longitude: userLatLng.lng 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    L.popup()
                        .setLatLng(userLatLng)
                        .setContent(`<div class="announcement">${data.message}</div>`)
                        .openOn(map);
                } else {
                    L.popup()
                        .setLatLng(userLatLng)
                        .setContent('Click within an area to predict crime trends')
                        .openOn(map);
                }
            });
        });

        // Reset position button
        document.getElementById('reset-position').addEventListener('click', function() {
            if (targetMarker) {
                map.removeLayer(targetMarker);
                targetMarker = null;
            }

            startRealTimeMovement(userMarker.getLatLng(), initialPosition);
        });

        // Initialize the application
        loadCrimeAreas();
        loadPoliceStations();
        updateTimeDisplay();
        setInterval(updateTimeDisplay, 10000);
    </script>
</body>
</html>