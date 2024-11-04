<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /inventory/login.php");
        exit;
    }
}

function checkAdmin() {
    checkLogin();
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        header("Location: /inventory/unauthorized.php");
        exit;
    }
}

// Function to check specific role
function hasRole($roleId) {
    return isset($_SESSION['role']) && $_SESSION['role'] == $roleId;
}