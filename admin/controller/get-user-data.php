<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo json_encode($user);

            $saveActivityLog->saveLog("Fetched user details for User ID: $user_id ({$user['name']}).");
        } else {
            echo json_encode(['error' => 'User not found']);
            $saveActivityLog->saveLog("Failed to fetch user. User ID: $user_id not found.");
        }
    } else {
        echo json_encode(['error' => 'Database error']);
        $saveActivityLog->saveLog("Database error while fetching User ID: $user_id.");
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No user ID provided']);
    $saveActivityLog->saveLog("Failed to fetch user. No User ID provided.");
}

$conn->close();
?>
