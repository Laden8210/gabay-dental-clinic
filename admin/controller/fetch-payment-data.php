<?php
require_once '../../config/config.php';
require_once '../../function/SaveActivityLog.php';

$saveActivityLog = new SaveActivityLog();

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

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'month' => $row['month'],
            'total_income' => $row['total_income']
        ];
    }

    echo json_encode($data);

    $recordCount = count($data);
    $saveActivityLog->saveLog("Fetched monthly income data. Records retrieved: $recordCount.");
} else {
    echo json_encode(['error' => 'Failed to fetch monthly income data.']);
    $saveActivityLog->saveLog("Failed to fetch monthly income data. Database error: " . $conn->error);
}

$conn->close();
?>
