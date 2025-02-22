<?php
require_once '../../config/config.php';


require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id = $_POST["appointment_id"];
    $amount_paid = $_POST["amount_paid"];
    $payment_method = $_POST["payment_method"];
    $payment_proof = "";


    if (!is_numeric($amount_paid) || $amount_paid <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid payment amount!"]);

        $saveActivityLog->saveLog("Failed to process payment for appointment ID: $appointment_id. Error message: Invalid payment amount.");

        exit;
    }

  
    $stmt = $conn->prepare("SELECT SUM(amount) AS total_due FROM appointment_services WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_due = $result->fetch_assoc()["total_due"] ?? 0;
    $stmt->close();


    $stmt = $conn->prepare("SELECT SUM(amount_paid) AS total_paid FROM payments WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_paid = $result->fetch_assoc()["total_paid"] ?? 0;
    $stmt->close();


    if (($total_paid + $amount_paid) > $total_due) {
        echo json_encode(["success" => false, "message" => "Payment exceeds the total amount due!"]);

        $saveActivityLog->saveLog("Failed to process payment for appointment ID: $appointment_id. Error message: Payment exceeds the total amount due.");
        exit;
    }


    if (!empty($_FILES["payment_proof"]["name"])) {
        $target_dir = "../../uploads/";
        $file_extension = pathinfo($_FILES["payment_proof"]["name"], PATHINFO_EXTENSION);
        $allowed_extensions = ["jpg", "jpeg", "png", "pdf"];

        if (!in_array(strtolower($file_extension), $allowed_extensions)) {
            echo json_encode(["success" => false, "message" => "Invalid file type!"]);

            $saveActivityLog->saveLog("Failed to process payment for appointment ID: $appointment_id. Error message: Invalid file type.");
            exit;
        }

     
        $encrypted_name = md5(uniqid(rand(), true)) . "." . $file_extension;
        $target_file = $target_dir . $encrypted_name;

        if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
            
            $payment_proof = $encrypted_name;
        } else {
            echo json_encode(["success" => false, "message" => "File upload failed!"]);
            exit;
        }
    }


    $stmt = $conn->prepare("INSERT INTO payments (appointment_id, amount_paid, payment_method, payment_proof) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $appointment_id, $amount_paid, $payment_method, $payment_proof);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);

        $saveActivityLog->saveLog("Payment processed successfully for appointment ID: $appointment_id");
    } else {
        echo json_encode(["success" => false, "message" => "Database error!"]);
        $saveActivityLog->saveLog("Failed to process payment for appointment ID: $appointment_id. Error message: Database error.");
    }

    $stmt->close();
    $conn->close();
}
?>
