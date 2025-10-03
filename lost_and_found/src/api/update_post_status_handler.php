<?php
// src/api/update_post_status_handler.php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$postId = $data['post_id'] ?? 0;
$userId = $_SESSION['user_id']; // The person trying to make the change.

if ($postId <= 0) {
    http_response_code(400); echo json_encode(['error' => 'Invalid Post ID.']); exit();
}

$conn = getDbConnection();

// SECURITY CHECK: We include `user_id = $2` in the WHERE clause.
// This means the query will only succeed if the post ID exists AND it is owned by the current user.
$sql = "UPDATE posts SET status = 'done' WHERE id = $1 AND user_id = $2";
$result = pg_query_params($conn, $sql, [$postId, $userId]);

// pg_affected_rows will be > 0 only if the update was successful.
if ($result && pg_affected_rows($result) > 0) {
    echo json_encode(['success' => 'Post marked as complete.']);
} else {
    http_response_code(403); // Forbidden or Not Found
    echo json_encode(['error' => 'You do not have permission to update this post, or the post was not found.']);
}

pg_close($conn);
?>