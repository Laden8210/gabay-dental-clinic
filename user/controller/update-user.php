<?php
require_once '../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $first_name = mysqli_real_escape_string($conn, $first_name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $role = mysqli_real_escape_string($conn, $role);

    
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($role)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
        exit;
    }


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format!']);
        exit;
    }

    if (strlen($password) < 8) {
        echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters long!']);
        exit;
    }

    if ($role != 'Admin' && $role != 'Employee') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid role!']);
        exit;
    }

    $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', password='$password', role='$role' WHERE id='$user_id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Account updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update account!']);
    }
}
?>
