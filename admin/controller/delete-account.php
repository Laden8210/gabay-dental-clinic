<?php 

require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);
    $clientId = isset($data['patient_id']) ? intval($data['patient_id']) : null;

    if (!$clientId) {
        echo json_encode(['success' => false, 'message' => 'Patient ID is required.']);
        $saveActivityLog->saveLog("Failed to delete patient - Error: Patient ID is required.");
        exit;
    }

    // Get patient name for better logging
    $patientQuery = $conn->prepare("SELECT first_name, last_name FROM clients WHERE id = ?");
    $patientQuery->bind_param("i", $clientId);
    $patientQuery->execute();
    $patientResult = $patientQuery->get_result();
    $patient = $patientResult->fetch_assoc();
    $patientName = $patient ? $patient['first_name'] . ' ' . $patient['last_name'] : 'Unknown Patient';
    $patientQuery->close();

    // Delete patient
    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Patient deleted successfully.']);
        $saveActivityLog->saveLog("Successfully deleted patient: $patientName (ID: $clientId).");
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete patient.']);
        $saveActivityLog->saveLog("Attempted to delete patient: $patientName (ID: $clientId) - Failed: Patient not found or database error.");
    }

    $stmt->close();
    $conn->close();
}
?>
