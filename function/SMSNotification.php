<?php
// ========================= CONFIGURATION ===========================
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Laden8210');
define('DB_NAME', 'gabay_dental_db');


// Establish database connection
try {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("ERROR: Could not connect. " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// =========================== SMS CLASS =============================
class SMS {
    public function sendSMS($phoneNumber, $message) {
        $url = 'https://nasa-ph.com/api/send-sms';
        $data = [
            'phone_number' => $phoneNumber,
            'message' => $message,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);

        if ($response === false) {
            return ['message' => 'cURL Error: ' . curl_error($ch)];
        }

        curl_close($ch);
        return json_decode($response, true);
    }
}

// ======================== MAIN EXECUTION ===========================
$sms = new SMS();

$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

// Absolute path for the log file (adjust as needed)
$logFile = __DIR__ . '/sms_log.txt';

$query = "SELECT a.id, c.mobile_number, c.first_name, a.appointment_date, a.appointment_time 
          FROM appointments a
          JOIN clients c ON a.client_id = c.id
          WHERE a.status = 0";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] ERROR: " . $conn->error . "\n", FILE_APPEND);
    die("Database query failed.");
}

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
        $logMessage .= "Status: FAILED | " . ($response['message'] ?? 'No response') . "\n";
    }

    // Write log to file
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Send final notification
$sms->sendSMS("09559786019", "SMS Notification has been sent successfully.");

// Close connections
$stmt->close();
$conn->close();
?>
