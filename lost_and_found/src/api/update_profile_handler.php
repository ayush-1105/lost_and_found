<?php
// src/api/update_profile_handler.php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$userId = $_SESSION['user_id'];
$conn = getDbConnection();

// --- Get existing user data to check for old image ---
$sql_select = "SELECT profile_image_url FROM users WHERE id = $1";
$result_select = pg_query_params($conn, $sql_select, [$userId]);
$user_data = pg_fetch_assoc($result_select);
$currentImageUrl = $user_data['profile_image_url'] ?? null;

// --- Handle Text and File Data ---
// Form data is in $_POST and $_FILES
$name = $_POST['name'] ?? '';
$age = (int)($_POST['age'] ?? 0);
$gender = $_POST['gender'] ?? '';
$bio = $_POST['bio'] ?? '';
$profileImageUrl = $currentImageUrl; // Default to the current image URL

// --- Image Upload Logic ---
if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
    $uploadDir = '../../public/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Create a unique filename
    $fileName = 'profile-' . $userId . '-' . uniqid() . '.' . pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
    $targetFilePath = $uploadDir . $fileName;

    // Move the new file to the uploads folder
    if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFilePath)) {
        // If a new image is successfully uploaded, delete the old one
        if ($currentImageUrl && file_exists('../../public/' . $currentImageUrl)) {
            unlink('../../public/' . $currentImageUrl);
        }
        // Set the new path to be saved in the database
        $profileImageUrl = 'uploads/' . $fileName;
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Sorry, there was an error uploading your file.']);
        exit();
    }
}

// --- Database Update Logic ---
$sql_update = "UPDATE users 
               SET name = $1, age = $2, gender = $3, bio = $4, profile_image_url = $5
               WHERE id = $6";

$params = [$name, $age, $gender, $bio, $profileImageUrl, $userId];
$result_update = pg_query_params($conn, $sql_update, $params);

if ($result_update) {
    $_SESSION['user_name'] = $name; // Update session name
    echo json_encode(['success' => 'Profile updated successfully.']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update profile.']);
}

pg_close($conn);
?>