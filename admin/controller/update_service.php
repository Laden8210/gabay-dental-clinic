<?php
require_once '../../config/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serviceId = isset($_POST['service_id']) ? intval($_POST['service_id']) : null;
    $serviceName = trim($_POST['service_name'] ?? '');
    $serviceDescription = trim($_POST['service_description'] ?? '');
    $servicePrice = $_POST['service_price'] ?? '';


    if (!$serviceId || empty($serviceName) || empty($serviceDescription) || !is_numeric($servicePrice) || floatval($servicePrice) < 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid or incomplete data provided.']);
        exit;
    }

    if ($stmt = $conn->prepare("UPDATE services SET name = ?, description = ?, price = ? WHERE id = ?")) {
        $stmt->bind_param('ssdi', $serviceName, $serviceDescription, $servicePrice, $serviceId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Service updated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to update service.']);
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL statement.']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
