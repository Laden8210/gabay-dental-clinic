
<?php
require_once '../../config/config.php';

require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

header('Content-Type: application/json'); 

if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];

    $sql = "DELETE FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);

            $saveActivityLog->saveLog("User deleted successfully");
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);

            $saveActivityLog->saveLog("Failed to delete user");
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);

        $saveActivityLog->saveLog("Database error");
        exit();
    }
}
?>
