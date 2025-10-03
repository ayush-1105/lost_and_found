<?php
// src/api/login_handler.php

require_once '../config/database.php';
header('Content-Type: application/json');

// It's crucial to start the session before any output
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Email and password are required.']);
    exit();
}

$email = $data['email'];
$password = $data['password'];

$conn = getDbConnection();

// Fetch the user by email
$sql = "SELECT id, name, email, password_hash, role FROM users WHERE email = $1";
$result = pg_query_params($conn, $sql, [$email]);
$user = pg_fetch_assoc($result);

// Verify the user exists and the password is correct
if ($user && password_verify($password, $user['password_hash'])) {
    // Password is correct, so create a session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['user_name'] = $user['name'];

    http_response_code(200);
    echo json_encode(['success' => 'Login successful.']);
} else {
    // Invalid credentials
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'Invalid email or password.']);
}

pg_close($conn);
?>