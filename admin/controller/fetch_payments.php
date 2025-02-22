<?php
require_once '../../config/config.php';

if (isset($_GET["appointment_id"])) {
    $appointment_id = $_GET["appointment_id"];

    $stmt = $conn->prepare("SELECT id, amount_paid, payment_method, payment_date, payment_proof, status FROM payments WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $payments = [];
    while ($row = $result->fetch_assoc()) {
        $payments[] = $row;
    }

    echo json_encode($payments);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>
