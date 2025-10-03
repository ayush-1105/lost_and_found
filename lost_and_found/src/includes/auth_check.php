<?php
// src/includes/auth_check.php

// If a session isn't already active, start one.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the 'user_id' is NOT set in the session.
if (!isset($_SESSION['user_id'])) {
    // If it's not set, the user is not logged in.
    // Redirect them to the login page and immediately stop the script.
    header('Location: login.php');
    exit();
}
?>