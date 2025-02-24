<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

if (isset($_GET["appointment_id"])) {
    $appointment_id = intval($_GET["appointment_id"]);

    $stmt = $conn->prepare("SELECT id, amount_paid, payment_method, payment_date, payment_proof, status FROM payments WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $payments = [];

        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }

        echo json_encode($payments);

        $paymentCount = count($payments);
        $saveActivityLog->saveLog("Fetched $paymentCount payment(s) for Appointment ID: $appointment_id.");
    } else {
        echo json_encode(['error' => 'Failed to fetch payment data.']);
        $saveActivityLog->saveLog("Failed to fetch payment data for Appointment ID: $appointment_id.");
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Appointment ID is required.']);
    $saveActivityLog->saveLog("Failed to fetch payments - Error: Missing Appointment ID.");
}

$conn->close();
?>
