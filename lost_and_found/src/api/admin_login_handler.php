<?php
// src/api/admin_login_handler.php
require_once '../config/database.php';
header('Content-Type: application/json');
session_start();

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$conn = getDbConnection();
$sql = "SELECT id, name, email, password_hash, role FROM users WHERE email = $1";
$result = pg_query_params($conn, $sql, [$email]);
$user = pg_fetch_assoc($result);

// --- SECURITY CHECK ---
// First, verify the user exists and the password is correct.
// Second, and most importantly, check if the user's role is 'admin'.
if ($user && password_verify($password, $user['password_hash']) && $user['role'] === 'admin') {
    // If all checks pass, create the session.
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['user_name'] = $user['name'];
    echo json_encode(['success' => 'Admin login successful.']);
} else {
    // If any check fails, send a generic error to prevent revealing which part was wrong.
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'Access Denied: Invalid credentials or not an admin.']);
}

pg_close($conn);
?>