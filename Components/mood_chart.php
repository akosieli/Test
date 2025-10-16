<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT mood_date, mood, mood_value 
        FROM mood_logs 
        WHERE user_id = ? 
        ORDER BY mood_date ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
