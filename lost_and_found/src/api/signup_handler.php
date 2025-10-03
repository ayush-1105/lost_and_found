<?php
// src/api/signup_handler.php
require_once '../config/database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['name'], $data['age'], $data['gender'], $data['email'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input.']);
    exit();
}

$name = $data['name'];
$age = (int)$data['age'];
$gender = $data['gender'];
$email = $data['email'];
$password = $data['password'];

if (strlen($password) < 6) {
    http_response_code(400);
    echo json_encode(['error' => 'Password must be at least 6 characters.']);
    exit();
}

$conn = getDbConnection();
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, age, gender, email, password_hash) VALUES ($1, $2, $3, $4, $5)";
$params = [$name, $age, $gender, $email, $password_hash];
$result = pg_query_params($conn, $sql, $params);

if ($result) {
    http_response_code(201);
    echo json_encode(['success' => 'User created successfully.']);
} else {
    http_response_code(409);
    echo json_encode(['error' => 'Email already exists.']);
}
pg_close($conn);
?>