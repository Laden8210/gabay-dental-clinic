<?php

require_once '../../config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $input = json_decode(file_get_contents('php://input'), true);
    $clientId = isset($input['client_id']) ? intval($input['client_id']) : null;

    if (!$clientId) {
        echo json_encode(['success' => false, 'message' => 'Client ID is required.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
        echo json_encode(['success' => true, 'client' => $client]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Client not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
