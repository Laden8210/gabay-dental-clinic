<?php
require_once '../../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $occupation = $_POST['occupation'];

    $upload_dir = "../../uploads/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }


    function encryptFileName($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return md5(uniqid(rand(), true)) . "." . $extension;
    }

    $profile_picture_filename = null;
    $id_picture_filename = null;

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
        $profile_picture_filename = encryptFileName($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_dir . $profile_picture_filename);
    }

    if (isset($_FILES['id_picture']) && $_FILES['id_picture']['size'] > 0) {
        $id_picture_filename = encryptFileName($_FILES['id_picture']['name']);
        move_uploaded_file($_FILES['id_picture']['tmp_name'], $upload_dir . $id_picture_filename);
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
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Query preparation failed"]);
    }

    $conn->close();
}
?>
