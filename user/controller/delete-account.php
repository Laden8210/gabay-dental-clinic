<?php 

require_once '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $data = json_decode(file_get_contents('php://input'), true);
    $clientId = isset($data['patient_id']) ? intval($data['patient_id']) : null;

    if (!$clientId) {
        echo json_encode(['success' => false, 'message' => 'Patient ID is required.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Patient deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete patient.']);
    }

    $stmt->close();

}