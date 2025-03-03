<?php
header('Content-Type: application/json');
require '../config/config.php';

$rawData = file_get_contents("php://input");
$requestData = json_decode($rawData, true);

$userId = $requestData['client_id'] ?? "";


if (empty($userId)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    exit;
}


$stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}

echo json_encode($user);


exit;
