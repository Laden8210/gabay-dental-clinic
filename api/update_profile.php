<?php
header("Content-Type: application/json");
require '../config/config.php';

// -- Configuration for Uploads --
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$allowedMimeTypes  = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize       = 2 * 1024 * 1024; // 2MB


function cleanInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}


function uploadFile($file, $uploadDir)
{
    global $allowedExtensions, $allowedMimeTypes, $maxFileSize;

    if (!isset($file) || $file['error'] !== 0) {
        return null;
    }

    $fileExt = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));


    if (!in_array($fileExt, $allowedExtensions)) {
        return null;
    }


    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file["tmp_name"]);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedMimeTypes)) {
        return null;
    }


    if ($file["size"] > $maxFileSize) {
        return null;
    }


    $newFileName = uniqid() . "." . $fileExt;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filePath = $uploadDir . $newFileName;


    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        return $newFileName;
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        $userId       = cleanInput($_POST["user_id"]);
        $firstName    = cleanInput($_POST["first_name"]);
        $lastName     = cleanInput($_POST["last_name"]);
        $age          = (int) $_POST["age"];
        $sex          = cleanInput($_POST["sex"]);
        $mobileNumber = cleanInput($_POST["mobile_number"]);
        $email        = cleanInput($_POST["email"]);

        $address      = cleanInput($_POST["address"]);
        $occupation   = cleanInput($_POST["occupation"]);
        $id_type      = cleanInput($_POST["id_type"]);


        if (
            empty($userId) || empty($firstName) || empty($lastName) || empty($age) ||
            empty($sex) || empty($mobileNumber) || empty($email) ||
            empty($address) || empty($occupation)
        ) {
            echo json_encode(["status" => "error", "message" => "All fields are required"]);
            exit;
        }


        $profilePicture = null;
        $idPicture      = null;

        if (isset($_FILES["profileImage"]) && $_FILES["profileImage"]["error"] === 0) {
            $profilePicture = uploadFile($_FILES["profileImage"], "../uploads/");
        }
        if (isset($_FILES["idImage"]) && $_FILES["idImage"]["error"] === 0) {
            $idPicture = uploadFile($_FILES["idImage"], "../uploads/");
        }


        $sql = "UPDATE clients
            SET first_name = ?,
                last_name = ?,
                age = ?,
                sex = ?,
                mobile_number = ?,
                email = ?,
                address = ?,
                occupation = ?,
                id_type = ?";


        if ($profilePicture) {
            $sql .= ", profile_picture = '$profilePicture'";
        }

        if ($idPicture) {
            $sql .= ", id_picture = '$idPicture'";
        }


        $sql .= " WHERE id = ?";

        $stmt = $conn->prepare($sql);


        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
            exit;
        }


        $stmt->bind_param(
            "ssissssssi",
            $firstName,
            $lastName,
            $age,
            $sex,
            $mobileNumber,
            $email,
            $address,
            $occupation,
            $id_type,
            $userId
        );





        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Profile updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed: " . $stmt->error]);
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "An error occurred: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method!"]);
}
