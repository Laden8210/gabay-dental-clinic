<?php
header("Content-Type: application/json; charset=UTF-8");
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}


$input = json_decode(file_get_contents("php://input"), true);


if (!isset($input['client_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid client ID']);
    exit;
}

$client_id = (int) $input['client_id'];

$sql = "
SELECT 
    a.id AS appointment_id, 
    a.appointment_date, 
    a.appointment_time, 
    a.notes, 
    a.status,
    s.id AS service_id, 
    s.name AS service_name, 
    s.description AS service_description, 
    s.price AS service_price, 
    aps.amount,
    IFNULL(p.total_paid, 0) AS total_paid
FROM appointments a
LEFT JOIN appointment_services aps ON a.id = aps.appointment_id
LEFT JOIN services s ON aps.service_id = s.id
LEFT JOIN (
    SELECT appointment_id, SUM(amount_paid) AS total_paid 
    FROM payments 
    WHERE status = 'Completed' 
    GROUP BY appointment_id
) p ON a.id = p.appointment_id
WHERE a.client_id = ?
    AND a.status IN (0, 1)
ORDER BY a.appointment_date DESC, a.appointment_time DESC;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
$total_balance = 0;
$total_current_appointments = 0;
$latest_appointment_date = null;

while ($row = $result->fetch_assoc()) {
    $appointment_id = $row['appointment_id'];

    if (!isset($appointments[$appointment_id])) {
        $appointments[$appointment_id] = [
            'appointment_id' => $appointment_id,
            'appointment_date' => $row['appointment_date'],
            'appointment_time' => $row['appointment_time'],
            'notes' => $row['notes'],
            'status' => $row['status'],
            'total_service_amount' => 0,
            'total_paid' => $row['total_paid'],
            'balance' => 0,
            'services' => []
        ];

        $total_current_appointments++;

        if (is_null($latest_appointment_date) || $row['appointment_date'] > $latest_appointment_date) {
            $latest_appointment_date = $row['appointment_date'];
        }
    }


    if (!is_null($row['service_id'])) {
        $appointments[$appointment_id]['services'][] = [
            'service_id' => $row['service_id'],
            'name' => $row['service_name'],
            'description' => $row['service_description'],
            'amount' => $row['amount']
        ];

        $appointments[$appointment_id]['total_service_amount'] += $row['amount'];
    }


    $appointments[$appointment_id]['balance'] = $appointments[$appointment_id]['total_service_amount'] - $appointments[$appointment_id]['total_paid'];


    $total_balance += $appointments[$appointment_id]['balance'];
}

$stmt->close();
$conn->close();

if (!empty($appointments)) {
    echo json_encode([
        'status' => 'success',

        'total_balance' => $total_balance,
        'total_current_appointments' => $total_current_appointments,
        'latest_appointment_date' => $latest_appointment_date

    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No appointments found']);
}
