<?php

require_once '../../config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceName = $_POST['service_name'] ?? '';
    $serviceDescription = $_POST['service_description'] ?? '';
    $servicePrice = $_POST['service_price'] ?? '';

    if (!$serviceName || !$serviceDescription || !$servicePrice) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }


    $sql = "SELECT * FROM services WHERE name = ? AND description = ? ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $serviceName, $serviceDescription);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Service already exists.']);
        exit;
    }

    try {
        
        $stmt = $conn->prepare("INSERT INTO services (name, description, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $serviceName, $serviceDescription, $servicePrice);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Service saved successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save service.']);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
