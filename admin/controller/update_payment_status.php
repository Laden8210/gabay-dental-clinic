<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

header("Content-Type: application/json");

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!isset($data["payment_id"]) || !isset($data["status"])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid request. Missing payment_id or status."]);
    $saveActivityLog->saveLog("Payment status update failed. Reason: Missing payment_id or status.");
    exit;
}

$payment_id = intval($data["payment_id"]); // Ensure it's numeric
$new_status = trim($data["status"]);

// Validate payment status
$valid_statuses = ["Pending", "Completed", "Failed"];
if (!in_array($new_status, $valid_statuses)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid payment status."]);
    $saveActivityLog->saveLog("Payment status update failed for Payment ID $payment_id. Reason: Invalid status '$new_status'.");
    exit;
}

// Prepare SQL statement
if ($stmt = $conn->prepare("UPDATE payments SET status = ? WHERE id = ?")) {
    $stmt->bind_param("si", $new_status, $payment_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Payment status updated successfully!"]);
        $saveActivityLog->saveLog("Payment ID $payment_id updated to status '$new_status'.");
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to update payment status."]);
        $saveActivityLog->saveLog("Payment status update failed for Payment ID $payment_id. Error: " . $stmt->error);
    }

    $stmt->close();
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Failed to prepare the query."]);
    $saveActivityLog->saveLog("Failed to prepare statement for Payment ID $payment_id. Error: " . $conn->error);
}

$conn->close();
?>
