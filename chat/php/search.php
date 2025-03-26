<?php
session_start();
include_once "config.php";
$outgoing_id = $_SESSION['unique_id'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
$output = "";

// Fetch current user's admin status
$current_user_query = mysqli_query($conn, "SELECT is_admin FROM users WHERE unique_id = {$outgoing_id}");
$current_user = mysqli_fetch_assoc($current_user_query);
$is_admin = $current_user['is_admin'];

// For regular users, only search among admins
if($is_admin == 0) {
    $sql = "SELECT * FROM users WHERE (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') 
            AND is_admin = 1 AND NOT unique_id = {$outgoing_id}";
} 
// For admins, search among all users
else {
    $sql = "SELECT * FROM users WHERE (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') 
            AND NOT unique_id = {$outgoing_id}";
}

$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) > 0){
    include_once "data.php";
}else{
    $output .= "No user found related to your search term";
}
echo $output;
?>