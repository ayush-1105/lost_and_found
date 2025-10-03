<?php
// src/api/update_post_handler.php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$userId = $_SESSION['user_id'];
$conn = getDbConnection();

// Form data is in $_POST and $_FILES
$postId = (int)($_POST['post_id'] ?? 0);

if ($postId <= 0) {
    http_response_code(400); echo json_encode(['error' => 'Invalid Post ID.']); exit();
}

// --- Security Check: Verify Ownership ---
$sql_select = "SELECT user_id, image_url FROM posts WHERE id = $1";
$result_select = pg_query_params($conn, $sql_select, [$postId]);
$post = pg_fetch_assoc($result_select);

if (!$post) {
    http_response_code(404); echo json_encode(['error' => 'Post not found.']); exit();
}
if ($post['user_id'] != $userId) {
    http_response_code(403); echo json_encode(['error' => 'You do not have permission to edit this post.']); exit();
}
// --- End Security Check ---

$currentImageUrl = $post['image_url'];
$newImageUrl = $currentImageUrl; // Default to old image

// --- Image Upload Logic ---
if (isset($_FILES['postImage']) && $_FILES['postImage']['error'] == 0) {
    $uploadDir = '../../public/uploads/';
    $fileName = 'post-' . $postId . '-' . uniqid() . '.' . pathinfo($_FILES['postImage']['name'], PATHINFO_EXTENSION);
    $targetFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['postImage']['tmp_name'], $targetFilePath)) {
        // If a new image is uploaded, delete the old one if it exists
        if ($currentImageUrl && file_exists('../../public/' . $currentImageUrl)) {
            unlink('../../public/' . $currentImageUrl);
        }
        $newImageUrl = 'uploads/' . $fileName;
    }
}

// --- Database Update Logic ---
$sql_update = "UPDATE posts SET 
                    type = $1, title = $2, location = $3, item_condition = $4, 
                    description = $5, image_url = $6
               WHERE id = $7 AND user_id = $8";

$params = [
    $_POST['type'], $_POST['title'], $_POST['location'], 
    $_POST['condition'], $_POST['description'], $newImageUrl, 
    $postId, $userId
];

$result_update = pg_query_params($conn, $sql_update, $params);

if ($result_update) {
    echo json_encode(['success' => 'Post updated successfully.']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update post.']);
}

pg_close($conn);
?>