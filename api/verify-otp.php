<?php
session_start();
header("Content-Type: application/json");

// Read and decode JSON input
$input = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($input['otp'])) {

    $userOTP = trim($input['otp']);
    $storedOTP = $_SESSION['otp'] ?? null;
    $expiry = $_SESSION['otp_expiry'] ?? 0;

    if (!$storedOTP) {
        echo json_encode(['success' => false, 'message' => 'No OTP found. Please request again.']);
        exit;
    }

    if (time() > $expiry) {
        echo json_encode(['success' => false, 'message' => 'OTP has expired.']);
        unset($_SESSION['otp'], $_SESSION['otp_expiry']);
        exit;
    }

    if ($userOTP == $storedOTP) {
        echo json_encode(['success' => true, 'message' => 'OTP verified successfully.']);
        unset($_SESSION['otp'], $_SESSION['otp_expiry']); 
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
