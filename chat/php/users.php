<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    
    // Check if current user is admin
    $current_user_query = mysqli_query($conn, "SELECT is_admin FROM users WHERE unique_id = {$outgoing_id}");
    $current_user = mysqli_fetch_assoc($current_user_query);
    $is_admin = $current_user['is_admin'];
    
    // Different SQL based on user type
    if($is_admin == 1) {
        // For admins - show all users
        $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
    } else {
        // For regular users - show only admins
        $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND is_admin = 1 ORDER BY user_id DESC";
    }
    
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>