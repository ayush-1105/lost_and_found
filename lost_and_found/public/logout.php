<?php
// public/logout.php

// 1. Start the session to access session variables
session_start();

// 2. Unset all of the session variables
$_SESSION = array();

// 3. Destroy the session
session_destroy();

// 4. Redirect to the login page
header("Location: login.php");
exit;
?>