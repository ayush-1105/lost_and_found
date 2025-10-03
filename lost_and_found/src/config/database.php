<?php

function getDbConnection() {
    $host = 'localhost';
    $port = '5432';
    $dbname = 'lost_and_found';
    $user = 'postgres';
    $password = 'ayush9021'; 

    $conn_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
    $conn = pg_connect($conn_string);

    if (!$conn) {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['error' => 'Database connection failed.']);
        exit();
    }
    return $conn;
}
?>