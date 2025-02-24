<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

header("Content-Type: application/json");

$saveActivityLog = new SaveActivityLog();
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($data["account_id"], $data["status"])) {
    $id = intval($data["account_id"]);
    $status = ($data["status"] === "Active") ? 0 : 1;

    if ($id <= 0) {
        $message = "Invalid account ID: $id";
        echo json_encode(["success" => false, "message" => $message]);
        $saveActivityLog->saveLog($message);
        exit;
    }

    $stmt = $conn->prepare("UPDATE clients SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        $status_text = ($status === 0) ? "Active" : "Inactive";
        $message = "Account ID $id status updated to $status_text.";
        echo json_encode(["success" => true, "message" => $message]);
        $saveActivityLog->saveLog($message);
    } else {
        $message = "Failed to update status for Account ID $id.";
        echo json_encode(["success" => false, "message" => $message]);
        $saveActivityLog->saveLog($message);
    }

    $stmt->close();
    $conn->close();
} else {
    $message = "Invalid request. Missing account_id or status.";
    echo json_encode(["success" => false, "message" => $message]);
    $saveActivityLog->saveLog($message);
}
?>
