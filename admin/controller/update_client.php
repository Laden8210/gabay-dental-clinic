<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $age = intval($_POST['age']);
    $sex = trim($_POST['sex']);
    $mobile_number = trim($_POST['mobile_number']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $address = trim($_POST['address']);
    $occupation = trim($_POST['occupation']);

    $upload_dir = "../../uploads/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    function encryptFileName($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return md5(uniqid(rand(), true)) . "." . $extension;
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $max_file_size = 2 * 1024 * 1024; // 2MB

    $profile_picture_filename = null;
    $id_picture_filename = null;

    function handleFileUpload($file, $upload_dir, $allowed_types, $max_file_size) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            if (!in_array($file['type'], $allowed_types)) {
                return ['error' => 'Invalid file type'];
            }
            if ($file['size'] > $max_file_size) {
                return ['error' => 'File exceeds maximum size'];
            }

            $encryptedName = encryptFileName($file['name']);
            if (move_uploaded_file($file['tmp_name'], $upload_dir . $encryptedName)) {
                return ['filename' => $encryptedName];
            } else {
                return ['error' => 'File upload failed'];
            }
        }
        return ['error' => 'No file uploaded or unknown error'];
    }

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
        $uploadResult = handleFileUpload($_FILES['profile_picture'], $upload_dir, $allowed_types, $max_file_size);
        if (isset($uploadResult['error'])) {
            echo json_encode(["status" => "error", "message" => $uploadResult['error']]);
            exit;
        }
        $profile_picture_filename = $uploadResult['filename'];
    }

    if (isset($_FILES['id_picture']) && $_FILES['id_picture']['size'] > 0) {
        $uploadResult = handleFileUpload($_FILES['id_picture'], $upload_dir, $allowed_types, $max_file_size);
        if (isset($uploadResult['error'])) {
            echo json_encode(["status" => "error", "message" => $uploadResult['error']]);
            exit;
        }
        $id_picture_filename = $uploadResult['filename'];
    }

    $sql = "UPDATE clients SET 
                first_name = ?, 
                last_name = ?, 
                age = ?, 
                sex = ?, 
                mobile_number = ?, 
                email = ?, 
                address = ?, 
                occupation = ?";

    $params = [$first_name, $last_name, $age, $sex, $mobile_number, $email, $address, $occupation];
    $types = "ssisssss";

    if ($profile_picture_filename) {
        $sql .= ", profile_picture = ?";
        $params[] = $profile_picture_filename;
        $types .= "s";
    }
    if ($id_picture_filename) {
        $sql .= ", id_picture = ?";
        $params[] = $id_picture_filename;
        $types .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Client updated successfully"]);

            $saveActivityLog->saveLog("Client ID $id updated successfully with changes in profile.");

        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
            $saveActivityLog->saveLog("Failed to update Client ID $id");
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Query preparation failed"]);
        $saveActivityLog->saveLog("Query preparation failed for Client ID $id");
    }

    $conn->close();
}
?>
