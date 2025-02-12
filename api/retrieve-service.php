<?php
header("Content-Type: application/json; charset=UTF-8");
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Query to fetch all services
$sql = "SELECT id, name, description, price FROM services";
$result = $conn->query($sql);

$services = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => (float) $row['price'] 
        ];
    }
    echo json_encode(['status' => 'success', 'data' => $services]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No services found']);
}

$conn->close();
?>
