<?php

header("Content-Type: application/json; charset=UTF-8");
require '../config/config.php';

// Debug: Check if request is actually reaching this file
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Debug: Print raw POST data
file_put_contents("debug.log", print_r($_POST, true));

if (!isset($_POST['client_id'], $_POST['appointment_date'], $_POST['appointment_time'], $_POST['serviceIds'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
    exit;
}

// Sanitize input
$client_id = (int) $_POST['client_id'];
$appointment_date = $conn->real_escape_string($_POST['appointment_date']);
$appointment_time = $conn->real_escape_string($_POST['appointment_time']);
$notes = isset($_POST['notes']) ? $conn->real_escape_string($_POST['notes']) : '';

// Convert comma-separated service IDs to an array
$serviceIds = explode(',', $_POST['serviceIds']);

if (empty($serviceIds)) {
    echo json_encode(['status' => 'error', 'message' => 'No services selected']);
    exit;
}

// Start MySQL transaction
$conn->begin_transaction();

try {
    // Insert appointment
    $stmt = $conn->prepare("INSERT INTO appointments (client_id, appointment_date, appointment_time, notes) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $client_id, $appointment_date, $appointment_time, $notes);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $appointment_id = $stmt->insert_id;
        
        // Insert services linked to the appointment
        $stmtService = $conn->prepare("INSERT INTO appointment_services (appointment_id, service_id, amount) VALUES (?, ?, ?)");
        foreach ($serviceIds as $service_id) {
            $service_id = (int) $service_id;

            // Fetch service price
            $serviceQuery = $conn->prepare("SELECT price FROM services WHERE id = ?");
            $serviceQuery->bind_param("i", $service_id);
            $serviceQuery->execute();
            $serviceQuery->bind_result($price);
            $serviceQuery->fetch();
            $serviceQuery->close();

            if ($price !== null) {
                $stmtService->bind_param("iid", $appointment_id, $service_id, $price);
                $stmtService->execute();
            }
        }
        $stmtService->close();

        // Commit transaction
        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Appointment created successfully']);
    } else {
        throw new Exception("Failed to create appointment");
    }

    $stmt->close();
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?>
