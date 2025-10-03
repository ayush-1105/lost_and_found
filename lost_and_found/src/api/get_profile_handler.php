<?php
// src/api/get_profile_handler.php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$userId = $_SESSION['user_id'];
$conn = getDbConnection();

// Prepare the final response array
$response = [
    'userDetails' => null,
    'userPosts' => []
];

// 1. Fetch User Details
$sqlUser = "SELECT id, name, age, gender, email, bio, profile_image_url FROM users WHERE id = $1";
$resultUser = pg_query_params($conn, $sqlUser, [$userId]);
$userDetails = pg_fetch_assoc($resultUser);

if ($userDetails) {
    $response['userDetails'] = $userDetails;
} else {
    http_response_code(404);
    echo json_encode(['error' => 'User not found.']);
    pg_close($conn);
    exit();
}

// 2. Fetch User's Posts
$sqlPosts = "SELECT id, title, type, created_at FROM posts WHERE user_id = $1 ORDER BY created_at DESC";
$resultPosts = pg_query_params($conn, $sqlPosts, [$userId]);
$userPosts = pg_fetch_all($resultPosts);

if ($userPosts) {
    $response['userPosts'] = $userPosts;
}

// 3. Send the combined response
echo json_encode($response);
pg_close($conn);
?>