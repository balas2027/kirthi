<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if (isset($_GET['start']) && isset($_GET['end'])) {
    $api_key = "5b3ce3597851110001cf6248f7d2b3b120ae46edb4f0096eb92383f7";
    $start = $_GET['start'];
    $end = $_GET['end'];

    $url = "https://api.openrouteservice.org/v2/directions/driving-car?api_key=$api_key&start=$start&end=$end";
    
    $response = file_get_contents($url);
    echo $response;
} else {
    echo json_encode(["error" => "Missing parameters"]);
}
?>
