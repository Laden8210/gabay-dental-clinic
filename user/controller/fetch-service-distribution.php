<?php
require_once '../../config/config.php';

$query = "
    SELECT 
        s.name AS service_name,
        COUNT(asv.appointment_id) AS service_count
    FROM appointment_services asv
    JOIN services s ON s.id = asv.service_id
    GROUP BY s.id
";

$result = $conn->query($query);
$data = [];

while($row = $result->fetch_assoc()) {
    $data[] = [
        'service_name' => $row['service_name'],
        'service_count' => $row['service_count']
    ];
}

echo json_encode($data);
?>
