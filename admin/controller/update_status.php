<?php
require_once '../../config/config.php';


require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id = $_POST["appointment_id"];
    $new_status = $_POST["status"];

    $stmt = $conn->prepare("SELECT status FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "Appointment not found!"]);
        exit;
    }

    $row = $result->fetch_assoc();
    $current_status = $row["status"];
    $stmt->close();

    
    if ($current_status == 2) {
        echo json_encode(["success" => false, "message" => "Cannot modify a completed appointment!"]);
        exit;
    }

    if ($new_status == 2) {
      
        $stmt = $conn->prepare("SELECT SUM(amount) AS total_cost FROM appointment_services WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total_cost = $row["total_cost"] ?? 0; 
        $stmt->close();

        $stmt = $conn->prepare("SELECT SUM(amount_paid) AS total_paid FROM payments WHERE appointment_id = ? AND status = 'Completed'");
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total_paid = $row["total_paid"] ?? 0;
        $stmt->close();

        $balance = $total_cost - $total_paid;

  
        if ($balance > 0) {
            echo json_encode(["success" => false, "message" => "Cannot complete appointment! Balance remaining: $" . number_format($balance, 2)]);

            $saveActivityLog->saveLog("Cannot complete appointment! Balance remaining: $" . number_format($balance, 2));

            exit;
        }
    }

    $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_status, $appointment_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Status updated successfully!"]);
        $saveActivityLog->saveLog( "Status updated successfully!");
    } else {
        echo json_encode(["success" => false, "message" => "Database error!"]);
        $saveActivityLog->saveLog( "Database error!");
    }

    $stmt->close();
    $conn->close();
}
?>
