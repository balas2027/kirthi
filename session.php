<?php
function checkUserSession() {
    session_start();
    
    if (!isset($_SESSION['user_email']) && !isset($_SESSION['police_id'])) {
        header("Location: login.php");
        exit();
    }
}

function checkAdminSession() {
    session_start();
    
    if (!isset($_SESSION['user_email']) && !isset($_SESSION['police_id'])) {
        header("Location: login.php");
        exit();
    }
    
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'user') {
        header("Location: user_page.php");
        exit();
    }
}

function getUserRole() {
    return $_SESSION['user_role'] ?? 'user';
}
?>