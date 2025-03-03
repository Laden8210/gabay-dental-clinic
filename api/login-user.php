<?php
header("Content-Type: application/json; charset=UTF-8");
require '../config/config.php';
require_once '../function/SMS.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}


$emailOrPhone = trim($_POST['emailOrPhone'] ?? '');
$password = trim($_POST['password'] ?? '');


if (empty($emailOrPhone) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Email/phone and password are required']);
    exit();
}

if (filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
    $sql = "SELECT * FROM clients WHERE email = ?";
} else {
    $sql = "SELECT * FROM clients WHERE mobile_number = ?";
}


$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    exit();
}


$stmt->bind_param("s", $emailOrPhone);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();


if (!$user) {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit();
}

if ($password !== $user['password']) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password!']);
    exit();
}


if(1 != $user['status']){

    $otp = rand(100000, 999999);
    $message = "Your OTP code is: $otp. This code is valid for 5 minutes.";

    $sms = new SMS();
    $response = $sms->sendSMS($user['mobile_number'], $message);

    if ($response && isset($response['message']) && $response['message'] == 'SMS sent successfully') {

        echo json_encode([
            "status" => "success",
            "message" => "Login successful!",
            "user_id" => $user['id'],
            "otp" => $otp
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to send OTP."
        ]);
    }


}else{
    echo json_encode(
        ["status" => "error",
        "message" => "Account is not active"]
    );
}

exit();
?>
