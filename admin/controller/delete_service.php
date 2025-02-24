<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

header('Content-Type: application/json');

$saveActivityLog = new SaveActivityLog();
$input = json_decode(file_get_contents('php://input'), true);
$serviceId = $input['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $serviceId) {
    // Get the service name for logging
    $serviceQuery = $conn->prepare("SELECT name FROM services WHERE id = ?");
    $serviceQuery->bind_param('i', $serviceId);
    $serviceQuery->execute();
    $serviceResult = $serviceQuery->get_result();
    $service = $serviceResult->fetch_assoc();
    $serviceName = $service['name'] ?? 'Unknown Service';

    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->bind_param('i', $serviceId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Service deleted successfully.']);
        $saveActivityLog->saveLog("Successfully deleted service: $serviceName (ID: $serviceId).");
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete service.']);
        $saveActivityLog->saveLog("Attempted to delete service: $serviceName (ID: $serviceId) - Failed: Database error.");
    }

    $stmt->close();
    $serviceQuery->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or missing service ID.']);
    $saveActivityLog->saveLog("Attempted to delete service - Failed: Invalid request or missing service ID.");
}

$conn->close();
?>
