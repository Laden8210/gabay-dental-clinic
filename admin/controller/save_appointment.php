<?php

require_once '../../config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $_POST['client_id'] ?? null;
    $firstName = $_POST['first_name'] ?? null;
    $lastName = $_POST['last_name'] ?? null;
    $age = $_POST['age'] ?? null;
    $sex = $_POST['sex'] ?? null;
    $mobileNumber = $_POST['mobile_number'] ?? null;
    $email = $_POST['email'] ?? null;
    $address = $_POST['address'] ?? null;
    $occupation = $_POST['occupation'] ?? null;
    $appointmentDate = $_POST['appointment_date'] ?? null;
    $appointmentTime = $_POST['appointment_time'] ?? null;
    $note = $_POST['note'] ?? null;
    $services = $_POST['services'] ?? [];

    if (!$appointmentDate || !$appointmentTime || empty($services)) {
        echo json_encode(['success' => false, 'message' => 'Appointment date, time, and services are required.']);
        exit;
    }

    $conn->begin_transaction();

    try {

        if (!$clientId) {
            if (!$firstName || !$lastName || !$age || !$sex || !$mobileNumber || !$email || !$address || !$occupation) {
                echo json_encode(['success' => false, 'message' => 'All client details are required for new clients.']);
                exit;
            }


            $randomPassword = bin2hex(random_bytes(4)); 

            $stmt = $conn->prepare("INSERT INTO clients (first_name, last_name, age, sex, mobile_number, email, address, occupation, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssissssss", $firstName, $lastName, $age, $sex, $mobileNumber, $email, $address, $occupation, $randomPassword);
            $stmt->execute();
            $clientId = $stmt->insert_id;
            $stmt->close();
        }

        $status = 1;

        $stmt = $conn->prepare("INSERT INTO appointments (client_id, appointment_date, appointment_time, notes, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $clientId, $appointmentDate, $appointmentTime, $note, $status);
        $stmt->execute();
        $appointmentId = $stmt->insert_id;
        $stmt->close();

     
        $stmt = $conn->prepare("INSERT INTO appointment_services (appointment_id, service_id) VALUES (?, ?)");
        foreach ($services as $serviceId) {
            $stmt->bind_param("ii", $appointmentId, $serviceId);
            $stmt->execute();
        }
        $stmt->close();

        $conn->commit();

        echo json_encode([
            'success' => true, 
            'message' => 'Appointment saved successfully.',

        ]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to save appointment: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
