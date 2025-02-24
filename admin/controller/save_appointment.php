<?php

require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = $_POST['client_id'] ?? null;
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $age = $_POST['age'] ?? null;
    $sex = $_POST['sex'] ?? '';
    $mobileNumber = trim($_POST['mobile_number'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $occupation = trim($_POST['occupation'] ?? '');
    $appointmentDate = $_POST['appointment_date'] ?? null;
    $appointmentTime = $_POST['appointment_time'] ?? null;
    $note = trim($_POST['note'] ?? '');
    $services = $_POST['services'] ?? [];

    // Validate required appointment fields
    if (!$appointmentDate || !$appointmentTime || empty($services)) {
        echo json_encode(['success' => false, 'message' => 'Appointment date, time, and services are required.']);
        $saveActivityLog->saveLog("Failed to save appointment. Missing date, time, or services.");
        exit;
    }

    $conn->begin_transaction();

    try {
        // New client registration
        if (!$clientId) {
            if (!$firstName || !$lastName || !$age || !$sex || !$mobileNumber || !$email || !$address || !$occupation) {
                echo json_encode(['success' => false, 'message' => 'All client details are required for new clients.']);
                $saveActivityLog->saveLog("Failed to save appointment. Incomplete client details.");
                exit;
            }

            // Validate age and email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
                $saveActivityLog->saveLog("Failed to save appointment. Invalid email: $email");
                exit;
            }

            if (!is_numeric($age) || $age <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid age provided.']);
                $saveActivityLog->saveLog("Failed to save appointment. Invalid age: $age");
                exit;
            }

            // Generate random 8-character password
            $randomPassword = bin2hex(random_bytes(4));

            // Insert new client
            $stmt = $conn->prepare("INSERT INTO clients (first_name, last_name, age, sex, mobile_number, email, address, occupation, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssissssss", $firstName, $lastName, $age, $sex, $mobileNumber, $email, $address, $occupation, $randomPassword);
            if (!$stmt->execute()) {
                throw new Exception("Failed to add new client: " . $stmt->error);
            }
            $clientId = $stmt->insert_id;
            $stmt->close();
        }

        // Create appointment
        $status = 1; // Default status (e.g., active/pending)
        $stmt = $conn->prepare("INSERT INTO appointments (client_id, appointment_date, appointment_time, notes, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $clientId, $appointmentDate, $appointmentTime, $note, $status);
        if (!$stmt->execute()) {
            throw new Exception("Failed to create appointment: " . $stmt->error);
        }
        $appointmentId = $stmt->insert_id;
        $stmt->close();

        // Insert selected services
        $stmt = $conn->prepare("INSERT INTO appointment_services (appointment_id, service_id) VALUES (?, ?)");
        foreach ($services as $serviceId) {
            $stmt->bind_param("ii", $appointmentId, $serviceId);
            if (!$stmt->execute()) {
                throw new Exception("Failed to link service ID $serviceId to appointment: " . $stmt->error);
            }
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Appointment saved successfully.',
            'client_id' => $clientId,
            'appointment_id' => $appointmentId
        ]);

        $saveActivityLog->saveLog("Appointment saved successfully for client ID: $clientId, appointment ID: $appointmentId");

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to save appointment: ' . $e->getMessage()]);
        $saveActivityLog->saveLog("Error saving appointment for client ID: $clientId. " . $e->getMessage());
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    $saveActivityLog->saveLog("Failed to save appointment. Invalid request method.");
}
?>
