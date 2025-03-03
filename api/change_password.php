<?php
header('Content-Type: application/json');
require '../config/config.php';

$rawData = file_get_contents("php://input");
$requestData = json_decode($rawData, true);

$oldPassword = $requestData['old_password'] ?? "";
$newPassword = $requestData['new_password'] ?? "";
$userId = $requestData['user_id'] ?? "";


if (empty($oldPassword) || empty($newPassword) || empty($userId)) {
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

if ($oldPassword !== $user['password']) {
    echo json_encode(['status' => 'error', 'message' => 'Incorrect old password']);
    exit;
}

$stmt = $conn->prepare("UPDATE clients SET password = ? WHERE id = ?");

$stmt->bind_param("si", $newPassword, $userId);

$stmt->execute();

if ($stmt->affected_rows > 0) {
    $response = ['status' => 'success', 'message' => 'Password updated successfully'];
} else {
    $response = ['status' => 'error', 'message' => 'Failed to update password'];
}

echo json_encode($response);
exit;
