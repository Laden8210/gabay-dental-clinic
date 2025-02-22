<?php
require_once '../../config/config.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$serviceId = $input['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $serviceId) {
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->bind_param('i', $serviceId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Service deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete service.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or missing service ID.']);
}

$conn->close();
?>
