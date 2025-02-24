<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Sanitize inputs
    $first_name = mysqli_real_escape_string($conn, $first_name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($role)) {
        $message = "Failed to update account: All fields are required.";
        echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
        $saveActivityLog->saveLog($message);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Failed to update account: Invalid email format ($email).";
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format!']);
        $saveActivityLog->saveLog($message);
        exit;
    }

    // Validate password length
    if (strlen($password) < 8) {
        $message = "Failed to update account: Password too short.";
        echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters long!']);
        $saveActivityLog->saveLog($message);
        exit;
    }

    // Validate role
    if ($role != 'Admin' && $role != 'Employee') {
        $message = "Failed to update account: Invalid role ($role).";
        echo json_encode(['status' => 'error', 'message' => 'Invalid role!']);
        $saveActivityLog->saveLog($message);
        exit;
    }

    // Update user data
    $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', password='$password', role='$role' WHERE id='$user_id'";

    if (mysqli_query($conn, $sql)) {
        $message = "Account ID $user_id updated successfully.";
        echo json_encode(['status' => 'success', 'message' => 'Account updated successfully!']);
        $saveActivityLog->saveLog($message);
    } else {
        $message = "Failed to update account ID $user_id: " . mysqli_error($conn);
        echo json_encode(['status' => 'error', 'message' => 'Failed to update account!']);
        $saveActivityLog->saveLog($message);
    }
}
?>
