<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($role)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required.'
        ]);

        $saveActivityLog->saveLog("Attempted to create account for $first_name $last_name - Failed: All fields are required.");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please enter a valid email address.'
        ]);

        $saveActivityLog->saveLog("Attempted to create account for $first_name $last_name - Failed: Invalid email address.");
        exit;
    }

    $email_check_query = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $email_check_query);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email already exists. Please choose another email.'
        ]);

        $saveActivityLog->saveLog("Attempted to create account for $first_name $last_name - Failed: Email already exists.");
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password must be at least 6 characters long.'
        ]);

        $saveActivityLog->saveLog("Attempted to create account for $first_name $last_name - Failed: Password too short.");
        exit;
    }

    $valid_roles = ['Admin', 'Employee'];
    if (!in_array($role, $valid_roles)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid role. Please select a valid role.'
        ]);

        $saveActivityLog->saveLog("Attempted to create account for $first_name $last_name - Failed: Invalid role selected.");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $role);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Account created successfully.'
        ]);

        $saveActivityLog->saveLog("Successfully created account for $first_name $last_name.");
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again.'
        ]);

        $saveActivityLog->saveLog("Attempted to create account for $first_name $last_name - Failed: Database error.");
    }

    $stmt->close();
    $conn->close();
}
