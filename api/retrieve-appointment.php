<?php
header("Content-Type: application/json; charset=UTF-8");
require '../config/config.php';

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);

// Validate JSON input
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
    aps.amount 
FROM appointments a
LEFT JOIN appointment_services aps ON a.id = aps.appointment_id
LEFT JOIN services s ON aps.service_id = s.id
WHERE a.client_id = ?
    AND a.status IN (0, 1) 
ORDER BY a.appointment_date DESC, a.appointment_time DESC;

";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];

while ($row = $result->fetch_assoc()) {
    $appointment_id = $row['appointment_id'];

    if (!isset($appointments[$appointment_id])) {
        $appointments[$appointment_id] = [
            'appointment_id' => $appointment_id,
            'appointment_date' => $row['appointment_date'],
            'appointment_time' => $row['appointment_time'],
            'notes' => $row['notes'],
            'status' => $row['status'],
            'services' => []
        ];
    }

    if (!is_null($row['service_id'])) {
        $appointments[$appointment_id]['services'][] = [
            'service_id' => $row['service_id'],
            'name' => $row['service_name'],
            'description' => $row['service_description'],
            'amount' => $row['amount']
        ];
    }
}

$stmt->close();
$conn->close();

if (!empty($appointments)) {
    echo json_encode(['status' => 'success', 'data' => array_values($appointments)]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No appointments found']);
}
