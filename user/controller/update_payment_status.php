<?php
require_once '../../config/config.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["payment_id"]) || !isset($data["status"])) {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}

$payment_id = $data["payment_id"];
$new_status = $data["status"];


$valid_statuses = ["Pending", "Completed", "Failed"];
if (!in_array($new_status, $valid_statuses)) {
    echo json_encode(["success" => false, "message" => "Invalid payment status."]);
    exit;
}


$stmt = $conn->prepare("UPDATE payments SET status = ? WHERE id = ?");
$stmt->bind_param("si", $new_status, $payment_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Payment status updated successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update payment status."]);
}

$stmt->close();
$conn->close();
?>
