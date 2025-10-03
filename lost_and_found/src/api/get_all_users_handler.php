<?php
// src/api/get_all_users_handler.php
require_once '../includes/admin_check.php'; // SECURITY: Only admins can access this.
require_once '../config/database.php';

header('Content-Type: application/json');

$conn = getDbConnection();

$sql = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
$result = pg_query($conn, $sql);
$users = pg_fetch_all($result);

echo json_encode($users ?: []);
pg_close($conn);
?>