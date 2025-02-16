<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Transaction Record</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="fw-semibold fs-6">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Patient ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Service(s)</th>
                        <th>Charge Amount</th>
                        <th>Total Payments</th>
                        <th>Remaining Balance</th>
                        <th>Status</th>
                        <th>Payments</th>
                        <th>Appointment Date</th>
                        <th>Time</th>
                        <th>Notes</th>
                        <th>Actions</th> <!-- New column for "View Appointment" -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "
              SELECT 
    a.id AS transaction_id,
    c.id AS patient_id,
    c.first_name,
    c.last_name,
    (SELECT GROUP_CONCAT(DISTINCT s.name SEPARATOR ', ') 
     FROM appointment_services asvc 
     JOIN services s ON asvc.service_id = s.id 
     WHERE asvc.appointment_id = a.id) AS services,
    (SELECT SUM(amount) 
     FROM appointment_services 
     WHERE appointment_id = a.id) AS charge_amount,
    (SELECT COALESCE(SUM(amount_paid), 0) 
     FROM payments 
     WHERE appointment_id = a.id) AS total_paid,
    a.appointment_date AS date,
    TIME_FORMAT(a.appointment_time, '%h:%i %p') AS time,
    a.notes
FROM appointments a
INNER JOIN clients c ON a.client_id = c.id
ORDER BY a.appointment_date DESC, a.appointment_time DESC;

                    ";

                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $appointment_id = $row["transaction_id"];
                            $charge_amount = $row["charge_amount"];
                            $total_paid = $row["total_paid"];
                            $remaining_balance = $charge_amount - $total_paid;

                            // Determine Payment Status
                            if ($remaining_balance <= 0) {
                                $status = "<span class='badge bg-success'>Paid</span>";
                            } elseif ($total_paid > 0) {
                                $status = "<span class='badge bg-warning'>Partial</span>";
                            } else {
                                $status = "<span class='badge bg-danger'>Unpaid</span>";
                            }

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($appointment_id) . "</td>";
                            echo "<td>" . htmlspecialchars($row["patient_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["first_name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["last_name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["services"]) . "</td>";
                            echo "<td>₱" . number_format($charge_amount, 2) . "</td>";
                            echo "<td>₱" . number_format($total_paid, 2) . "</td>";
                            echo "<td>₱" . number_format($remaining_balance, 2) . "</td>";
                            echo "<td>" . $status . "</td>";

                            // View Payments Button
                            echo "<td>
                                    <button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#paymentModal$appointment_id'>
                                        View Payments
                                    </button>
                                  </td>";

                            echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["time"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["notes"]) . "</td>";

                            // View Appointment Button
                            echo "<td>
                                    <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#appointmentModal$appointment_id'>
                                        View Appointment
                                    </button>
                                  </td>";

                            echo "</tr>";

                            // Payment Modal
                            echo "
                            <div class='modal fade' id='paymentModal$appointment_id' tabindex='-1' aria-labelledby='paymentModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='paymentModalLabel'>Payments for Appointment #$appointment_id</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <ul class='list-group'>";

                            // Fetch payments for this appointment
                            $payment_sql = "
                            SELECT amount_paid, payment_method, status, payment_proof, DATE_FORMAT(payment_date, '%Y-%m-%d') AS payment_date
                            FROM payments WHERE appointment_id = $appointment_id ORDER BY payment_date DESC";

                            $payment_result = $conn->query($payment_sql);
                            if ($payment_result->num_rows > 0) {
                                while ($payment_row = $payment_result->fetch_assoc()) {
                                    $proof_image = $payment_row["payment_proof"] ? "<br><a href='" . htmlspecialchars($payment_row["payment_proof"]) . "' class='btn btn-primary btn-sm' target='_blank'>View Proof</a>" : "<br><span class='text-muted'>No proof uploaded</span>";

                                    echo "<li class='list-group-item'>
                                        <strong>₱" . number_format($payment_row["amount_paid"], 2) . "</strong>
                                        <br>Method: " . htmlspecialchars($payment_row["payment_method"]) . "
                                        <br>Status: " . htmlspecialchars($payment_row["status"]) . "
                                        <br>Date: " . htmlspecialchars($payment_row["payment_date"]) . "
                                        $proof_image
                                    </li>";
                                }
                            } else {
                                echo "<li class='list-group-item text-muted'>No payments found.</li>";
                            }

                            echo "          </ul>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>";

                            // Appointment Details Modal
                            echo "
                            <div class='modal fade' id='appointmentModal$appointment_id' tabindex='-1' aria-labelledby='appointmentModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='appointmentModalLabel'>Appointment Details</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <p><strong>Patient Name:</strong> " . htmlspecialchars($row["first_name"]) . " " . htmlspecialchars($row["last_name"]) . "</p>
                                            <p><strong>Services:</strong> " . htmlspecialchars($row["services"]) . "</p>
                                            <p><strong>Appointment Date:</strong> " . htmlspecialchars($row["date"]) . "</p>
                                            <p><strong>Time:</strong> " . htmlspecialchars($row["time"]) . "</p>
                                            <p><strong>Notes:</strong> " . htmlspecialchars($row["notes"]) . "</p>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>