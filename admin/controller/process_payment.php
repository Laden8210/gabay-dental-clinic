<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id = $_POST["appointment_id"] ?? null;
    $amount_paid = $_POST["amount_paid"] ?? null;
    $payment_method = $_POST["payment_method"] ?? null;
    $payment_proof = "";

    // Validate required fields
    if (!$appointment_id || !$amount_paid || !$payment_method) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        $saveActivityLog->saveLog("Failed payment: Missing fields for appointment ID: $appointment_id");
        exit;
    }

    // Validate payment amount
    if (!is_numeric($amount_paid) || $amount_paid <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid payment amount!"]);
        $saveActivityLog->saveLog("Failed payment: Invalid amount for appointment ID: $appointment_id");
        exit;
    }

    // Get total due for the appointment
    $stmt = $conn->prepare("SELECT SUM(amount) AS total_due FROM appointment_services WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_due = $result->fetch_assoc()["total_due"] ?? 0;
    $stmt->close();

    // Get total paid so far
    $stmt = $conn->prepare("SELECT SUM(amount_paid) AS total_paid FROM payments WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_paid = $result->fetch_assoc()["total_paid"] ?? 0;
    $stmt->close();

    // Validate payment limit
    if (($total_paid + $amount_paid) > $total_due) {
        echo json_encode(["success" => false, "message" => "Payment exceeds total due!"]);
        $saveActivityLog->saveLog("Failed payment: Overpayment for appointment ID: $appointment_id");
        exit;
    }

    // Handle payment proof upload
    if (!empty($_FILES["payment_proof"]["name"])) {
        $target_dir = "../../uploads/";
        $file_extension = strtolower(pathinfo($_FILES["payment_proof"]["name"], PATHINFO_EXTENSION));
        $allowed_extensions = ["jpg", "jpeg", "png", "pdf"];

        if (!in_array($file_extension, $allowed_extensions)) {
            echo json_encode(["success" => false, "message" => "Invalid file type!"]);
            $saveActivityLog->saveLog("Failed payment: Invalid file type for appointment ID: $appointment_id");
            exit;
        }

        $encrypted_name = md5(uniqid(rand(), true)) . "." . $file_extension;
        $target_file = $target_dir . $encrypted_name;

        if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
            $payment_proof = $encrypted_name;
        } else {
            echo json_encode(["success" => false, "message" => "File upload failed!"]);
            $saveActivityLog->saveLog("Failed payment: File upload error for appointment ID: $appointment_id");
            exit;
        }
    }

    // Insert payment into DB
    $stmt = $conn->prepare("INSERT INTO payments (appointment_id, amount_paid, payment_method, payment_proof) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $appointment_id, $amount_paid, $payment_method, $payment_proof);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Payment successful."]);
        $saveActivityLog->saveLog("Payment of $amount_paid processed for appointment ID: $appointment_id");
    } else {
        echo json_encode(["success" => false, "message" => "Database error!"]);
        $saveActivityLog->saveLog("Failed payment: DB error for appointment ID: $appointment_id");
    }

    $stmt->close();
    $conn->close();
}
?>
