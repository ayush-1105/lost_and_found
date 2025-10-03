<?php
// src/api/create_post_handler.php

require_once '../includes/auth_check.php';
require_once '../config/database.php';

header('Content-Type: application/json');

// --- Form data is now in $_POST for text fields and $_FILES for files ---
$userId = $_SESSION['user_id'];
$postType = $_POST['type'] ?? '';
$postTitle = $_POST['title'] ?? '';
$postLocation = $_POST['location'] ?? '';
$postCondition = $_POST['condition'] ?? '';
$postDescription = $_POST['description'] ?? '';
$postImageURL = null; // Default to null

// --- Image Upload Handling Logic ---
if (isset($_FILES['postImage']) && $_FILES['postImage']['error'] == 0) {
    $uploadDir = '../../public/uploads/';
    // Create a unique filename to prevent overwriting
    $fileName = uniqid() . '-' . basename($_FILES['postImage']['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array(strtolower($fileType), $allowTypes)) {
        // Move the file from the temporary PHP directory to your uploads folder
        if (move_uploaded_file($_FILES['postImage']['tmp_name'], $targetFilePath)) {
            // The path to save in the database should be relative to the public root
            $postImageURL = 'uploads/' . $fileName;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Sorry, there was an error uploading your file.']);
            exit();
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed.']);
        exit();
    }
}

// --- Database Interaction ---
$conn = getDbConnection();

$sql = "INSERT INTO posts (user_id, type, title, location, item_condition, description, image_url, status) 
        VALUES ($1, $2, $3, $4, $5, $6, $7, 'open')";
$params = [
    $userId,
    $postType,
    $postTitle,
    $postLocation,
    $postCondition,
    $postDescription,
    $postImageURL
];

$result = pg_query_params($conn, $sql, $params);

if ($result) {
    http_response_code(201);
    echo json_encode(['success' => 'Post created successfully!']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create post. Please try again.']);
}

pg_close($conn);
?>