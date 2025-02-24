<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

header('Content-Type: application/json'); 

if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);

    // Fetch user details for logging
    $userQuery = $conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
    $userQuery->bind_param("i", $user_id);
    $userQuery->execute();
    $userResult = $userQuery->get_result();
    $user = $userResult->fetch_assoc();
    $userName = $user ? $user['first_name'] . ' ' . $user['last_name'] : 'Unknown User';
    $userQuery->close();

    // Delete user
    $sql = "DELETE FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
            $saveActivityLog->saveLog("Successfully deleted user: $userName (ID: $user_id).");
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
            $saveActivityLog->saveLog("Failed to delete user: $userName (ID: $user_id) - Database execution error.");
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
        $saveActivityLog->saveLog("Database error while attempting to delete user (ID: $user_id).");
    }
}

$conn->close();
?>
