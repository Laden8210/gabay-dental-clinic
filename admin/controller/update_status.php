<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id = isset($_POST["appointment_id"]) ? intval($_POST["appointment_id"]) : null;
    $new_status = isset($_POST["status"]) ? intval($_POST["status"]) : null;

    // Validate input
    if (!$appointment_id || !in_array($new_status, [0, 1, 2])) {
        http_response_code(400); // Bad Request
        echo json_encode(["success" => false, "message" => "Invalid input provided."]);
        $saveActivityLog->saveLog("Invalid input for appointment update.");
        exit;
    }

    // Check if appointment exists
    $stmt = $conn->prepare("SELECT status FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404); // Not Found
        echo json_encode(["success" => false, "message" => "Appointment not found!"]);
        $saveActivityLog->saveLog("Attempted to update non-existing appointment ID: $appointment_id");
        exit;
    }

    $current_status = $result->fetch_assoc()["status"];
    $stmt->close();

    // Prevent modifying completed appointments
    if ($current_status == 2) {
        http_response_code(403); // Forbidden
        echo json_encode(["success" => false, "message" => "Cannot modify a completed appointment!"]);
        $saveActivityLog->saveLog("Attempted to modify a completed appointment ID: $appointment_id");
        exit;
    }

    // If marking as completed, check for balance
    if ($new_status == 2) {
        // Get total cost
        $stmt = $conn->prepare("SELECT SUM(amount) AS total_cost FROM appointment_services WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $total_cost = $stmt->get_result()->fetch_assoc()["total_cost"] ?? 0;
        $stmt->close();

        // Get total paid
        $stmt = $conn->prepare("SELECT SUM(amount_paid) AS total_paid FROM payments WHERE appointment_id = ? AND status = 'Completed'");
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $total_paid = $stmt->get_result()->fetch_assoc()["total_paid"] ?? 0;
        $stmt->close();

        $balance = $total_cost - $total_paid;

        if ($balance > 0) {
            http_response_code(409); // Conflict
            $message = "Cannot complete appointment! Balance remaining: $" . number_format($balance, 2);
            echo json_encode(["success" => false, "message" => $message]);
            $saveActivityLog->saveLog($message);
            exit;
        }
    }

    // Update appointment status
    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_status, $appointment_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Status updated successfully!"]);
        $saveActivityLog->saveLog("Appointment ID: $appointment_id status updated to $new_status.");
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["success" => false, "message" => "Database error!"]);
        $saveActivityLog->saveLog("Database error while updating appointment ID: $appointment_id");
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
