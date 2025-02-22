<?php
require_once '../../config/config.php';

$query = "
    SELECT
        MONTH(payment_date) AS month,
        SUM(amount_paid) AS total_income
    FROM payments
    GROUP BY MONTH(payment_date)
    ORDER BY MONTH(payment_date);
";

$result = $conn->query($query);
$data = [];

while($row = $result->fetch_assoc()) {
    $data[] = [
        'month' => $row['month'],
        'total_income' => $row['total_income']
    ];
}

echo json_encode($data);
?>
