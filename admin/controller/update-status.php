<?php
require_once '../../config/config.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($data["account_id"], $data["status"])) {
    $id = intval($data["account_id"]);
    $status = ($data["status"] === "Active") ? 0 : 1;

    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid account ID"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE clients SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Status updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update status"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
