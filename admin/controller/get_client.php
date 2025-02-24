<?php

require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = json_decode(file_get_contents('php://input'), true);
    $clientId = isset($input['client_id']) ? intval($input['client_id']) : null;

    if (!$clientId) {
        echo json_encode(['success' => false, 'message' => 'Client ID is required.']);
        $saveActivityLog->saveLog("Failed to fetch client details. Error: Client ID is required.");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
        echo json_encode(['success' => true, 'client' => $client]);

        $saveActivityLog->saveLog("Fetched client details for Client ID: $clientId ({$client['first_name']} {$client['last_name']}).");
    } else {
        echo json_encode(['success' => false, 'message' => 'Client not found.']);
        $saveActivityLog->saveLog("Failed to fetch client details. Client ID: $clientId not found.");
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    $saveActivityLog->saveLog("Invalid request method used for fetching client details.");
}

$conn->close();
?>
