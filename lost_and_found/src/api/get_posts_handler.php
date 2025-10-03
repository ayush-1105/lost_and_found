<?php
// src/api/get_posts_handler.php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$postType = $_GET['type'] ?? '';

if ($postType !== 'lost' && $postType !== 'found') {
    http_response_code(400);
    echo json_encode(['error' => 'A valid post type is required.']);
    exit();
}

$conn = getDbConnection();

$sql = "SELECT
            p.id, p.user_id, p.title, p.location, p.image_url,
            p.status, p.created_at,
            u.name as author_name,
            u.profile_image_url as author_avatar
        FROM posts p
        JOIN users u ON p.user_id = u.id
        WHERE p.type = $1
        ORDER BY p.created_at DESC";

$result = pg_query_params($conn, $sql, [$postType]);

if ($result === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Database query failed.']);
} else {
    $posts = pg_fetch_all($result);
    echo json_encode($posts);
}

pg_close($conn);
?>