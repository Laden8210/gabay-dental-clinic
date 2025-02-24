<?php
include 'config/config.php';
include 'SMS.php';

$sms = new SMS();

$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

// Log file path
$logFile = 'sms_log.txt';

$query = "SELECT a.id, c.mobile_number, c.first_name, a.appointment_date, a.appointment_time 
          FROM appointments a
          JOIN clients c ON a.client_id = c.id
          WHERE a.status = 0";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $phoneNumber = $row['mobile_number'];
    $clientName = $row['first_name'];
    $appointmentDate = $row['appointment_date'];
    $appointmentTime = $row['appointment_time'];

    $message = "Hello $clientName, this is a reminder for your dental appointment on $appointmentDate at $appointmentTime. Please confirm or contact us if you need to reschedule.";

    $response = $sms->sendSMS($phoneNumber, $message);

    // Prepare log message
    $logMessage = "[" . date('Y-m-d H:i:s') . "] ";
    $logMessage .= "To: $phoneNumber | Client: $clientName | Date: $appointmentDate | Time: $appointmentTime | ";

    if ($response && isset($response['message']) && $response['message'] == 'SMS sent successfully') {
        echo "SMS sent successfully to $phoneNumber\n";
        $logMessage .= "Status: SUCCESS\n";
    } else {
        echo "Failed to send SMS to $phoneNumber\n";
        $logMessage .= "Status: FAILED\n";
    }

    // Write log to file
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

$stmt->close();
$conn->close();
?>
