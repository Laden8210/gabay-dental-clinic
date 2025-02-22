<?php
require_once '../../config/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceId = $_POST['service_id'] ?? null;
    $serviceName = $_POST['service_name'] ?? '';
    $serviceDescription = $_POST['service_description'] ?? '';
    $servicePrice = $_POST['service_price'] ?? '';

    if ($serviceId && $serviceName && $serviceDescription && $servicePrice) {
        $stmt = $conn->prepare("UPDATE services SET name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->bind_param('ssdi', $serviceName, $serviceDescription, $servicePrice, $serviceId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Service updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update service.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Incomplete data provided.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
