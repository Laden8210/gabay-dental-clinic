<?php

require_once 'config/config.php';

header('Content-Type: application/json');

session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email'], $data['password'])) {
    echo json_encode(["error" => "Invalid input."]);
    exit;
}

$email = trim($data['email']);
$password = trim($data['password']);

if (empty($email) || empty($password)) {
    echo json_encode(["error" => "Both fields are required."]);
    exit;
}

$sql = "SELECT id, email, password, role FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "Database query failed."]);
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if ($password ==  $user['password']) {
        echo json_encode([
            "success" => "Login successful.",
            "role" => $user['role'],
            "user_id" => $user['id']
        ]);

        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];
    } else {
        echo json_encode(["error" => "Invalid email or password."]);
    }
} else {
    echo json_encode(["error" => "Invalid email or password."]);
}

$stmt->close();
$conn->close();
