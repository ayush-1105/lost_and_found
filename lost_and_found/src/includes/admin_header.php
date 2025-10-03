<?php
// src/includes/admin_header.php
// This is a special header for the admin section.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// It runs the admin check immediately to protect all admin pages.
require_once 'admin_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/faviconlost.png">
    <title>Admin Panel - Lost & Found</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/toaster.css">
</head>
<body>