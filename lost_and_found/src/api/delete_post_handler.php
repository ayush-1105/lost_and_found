<?php
// src/api/delete_post_handler.php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['post_id'] ?? 0;
$userId = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'];

if ($postId <= 0) {
    http_response_code(400); echo json_encode(['error' => 'Invalid Post ID.']); exit();
}

$conn = getDbConnection();

// First, find out who owns the post we are trying to delete.
$sql_select = "SELECT user_id FROM posts WHERE id = $1";
$result_select = pg_query_params($conn, $sql_select, [$postId]);
$post = pg_fetch_assoc($result_select);

if (!$post) {
    http_response_code(404); echo json_encode(['error' => 'Post not found.']); exit();
}

// SECURITY CHECK: Allow deletion ONLY if the logged-in user is the owner OR is an admin.
if ($post['user_id'] == $userId || $userRole === 'admin') {
    $sql_delete = "DELETE FROM posts WHERE id = $1";
    $result_delete = pg_query_params($conn, $sql_delete, [$postId]);

    if ($result_delete && pg_affected_rows($result_delete) > 0) {
        echo json_encode(['success' => 'Post deleted successfully.']);
    } else {
        http_response_code(500); echo json_encode(['error' => 'Failed to delete post.']);
    }
} else {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'You do not have permission to delete this post.']);
}

pg_close($conn);
?>