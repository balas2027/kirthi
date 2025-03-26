
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (isset($_GET['start']) && isset($_GET['end'])) {
    $apiKey = "YOUR_API_KEY"; // Replace with your OpenRouteService API Key
    $start = $_GET['start'];
    $end = $_GET['end'];

    $url = "https://api.openrouteservice.org/v2/directions/driving-car?api_key=$apiKey&start=$start&end=$end";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;
} else {
    echo json_encode(["error" => "Missing parameters"]);
}
?>
