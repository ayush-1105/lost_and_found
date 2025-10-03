<?php
// src/api/get_post_details_handler.php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

header('Content-Type: application/json');

// Get the post ID from the URL query parameter (?id=...)
$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($postId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid Post ID.']);
    exit();
}

$conn = getDbConnection();

// SQL JOIN to get all post details plus author information
$sql = "SELECT 
            p.*,
            u.name as author_name,
            u.email as author_email
        FROM posts p
        JOIN users u ON p.user_id = u.id
        WHERE p.id = $1";

$result = pg_query_params($conn, $sql, [$postId]);
$post = pg_fetch_assoc($result);

if ($post) {
    echo json_encode($post);
} else {
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'Post not found.']);
}

pg_close($conn);
?> 