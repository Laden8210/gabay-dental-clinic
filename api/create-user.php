<?php
header("Content-Type: application/json");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Referrer-Policy: no-referrer-when-downgrade");

require '../config/config.php';

$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize = 2 * 1024 * 1024; // 2MB

function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isValidMobileNumber($number) {
    return preg_match('/^09[0-9]{9}$/', $number);
}

function isValidName($name) {
    return preg_match('/^[A-Za-z\s\-]+$/', $name); 
}

function isValidAge($age) {
    return filter_var($age, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 120]]);
}

function isValidGender($gender) {
    return in_array(strtolower($gender), ['male', 'female', 'other']);
}

function uploadFile($file, $uploadDir) {
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

    // Generate unique file name
    $newFileName = uniqid() . "." . $fileExt;
    $filePath = $uploadDir . $newFileName;

    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        return $newFileName; 
    }

    return null;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        session_start();
        if (!isset($_SESSION['last_register_time'])) {
            $_SESSION['last_register_time'] = time();
        } else {
            $timeDiff = time() - $_SESSION['last_register_time'];
            if ($timeDiff < 30) {
                echo json_encode(["status" => "error", "message" => "Too many requests. Please wait!"]);
                exit;
            }
            $_SESSION['last_register_time'] = time();
        }

        $firstName = cleanInput($_POST["first_name"]);
        $lastName = cleanInput($_POST["last_name"]);
        $age = (int) $_POST["age"];
        $sex = cleanInput($_POST["sex"]);
        $mobileNumber = cleanInput($_POST["mobile_number"]);
        $email = cleanInput($_POST["email"]);
        $password = $_POST["password"];
        $address = cleanInput($_POST["address"]);
        $occupation = cleanInput($_POST["occupation"]);

        $id_type = cleanInput($_POST["id_type"]);

        // **Validation**
        if (empty($firstName) || empty($lastName) || empty($age) || empty($sex) || empty($mobileNumber) || empty($email) || empty($password) || empty($address) || empty($occupation)) {
            echo json_encode(["status" => "error", "message" => "All fields are required!"]);
            exit;
        }

        if (!isValidName($firstName) || !isValidName($lastName)) {
            echo json_encode(["status" => "error", "message" => "Invalid name format!"]);
            exit;
        }

        if (!isValidAge($age)) {
            echo json_encode(["status" => "error", "message" => "Invalid age!"]);
            exit;
        }

        if (!isValidGender($sex)) {
            echo json_encode(["status" => "error", "message" => "Invalid gender!"]);
            exit;
        }

        if (!isValidMobileNumber($mobileNumber)) {
            echo json_encode(["status" => "error", "message" => "Invalid mobile number! Must be a valid PH number."]);
            exit;
        }

        if (!isValidEmail($email)) {
            echo json_encode(["status" => "error", "message" => "Invalid email format!"]);
            exit;
        }

        if (strlen($password) < 6) {
            echo json_encode(["status" => "error", "message" => "Password must be at least 6 characters long!"]);
            exit;
        }

        // Check if email or mobile number is already registered
        $stmt = $conn->prepare("SELECT id FROM clients WHERE email = ? OR mobile_number = ?");
        $stmt->bind_param("ss", $email, $mobileNumber);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Email or Mobile Number already registered!"]);
            exit;
        }
        $stmt->close();

        // Upload files
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $profilePicture = uploadFile($_FILES["profileImage"], $uploadDir);
        $idPicture = uploadFile($_FILES["idImage"], $uploadDir);


        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO clients (first_name, last_name, age, sex, mobile_number, email, password, address, occupation, profile_picture, id_picture, status, id_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?)");
        $stmt->bind_param("ssisssssssss", $firstName, $lastName, $age, $sex, $mobileNumber, $email, $password, $address, $occupation, $profilePicture, $idPicture, $id_type);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Registration successful!"]);
        } else {
            error_log("Database error: " . $stmt->error);
            echo json_encode(["status" => "error", "message" => "An unexpected error occurred."]);
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method!"]);
}
