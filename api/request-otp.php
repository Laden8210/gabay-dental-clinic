<?php
require_once '../function/SMS.php';
session_start();

header("Content-Type: application/json");

// Read and decode JSON input
$input = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['phone_number'])) {

    $phoneNumber = trim($input['phone_number']);

    if (empty($phoneNumber)) {
        echo json_encode(['success' => false, 'message' => 'Phone number is required.']);
        exit;
    }

    $otp = rand(100000, 999999);
    $message = "Your OTP code is: $otp. This code is valid for 5 minutes.";

    $sms = new SMS();
    $response = $sms->sendSMS($phoneNumber, $message);

    if ($response && isset($response['message']) && $response['message'] == 'SMS sent successfully') {

     
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = time() + 300;

        echo json_encode(['success' => true, 'message' => 'OTP sent successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send OTP.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
