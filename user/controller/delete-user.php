
<?php
require_once '../../config/config.php';


header('Content-Type: application/json'); 

if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];

    $sql = "DELETE FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
        exit();
    }
}
?>
