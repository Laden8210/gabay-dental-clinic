<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">System Activity</h6>
        <button class="btn btn-success" data-toggle="modal" data-target="#createAccountModal">Create Account</button>
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
                        <th>Service</th>
                        <th>Charge Amount</th>
                        <th>Amount Paid</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    $sql = "
                SELECT 
                    appointments.id AS transaction_id,
                    clients.id AS patient_id,
                    clients.first_name,
                    clients.last_name,
                    SUM(appointment_services.amount) AS charge_amount,
                    SUM(appointment_services.amount) AS amount_paid, -- Adjust this if payment logic differs
                    appointments.appointment_date AS date,
                    TIME_FORMAT(appointments.appointment_time, '%h:%i %p') AS time,
                    appointments.notes
                FROM appointments
                INNER JOIN clients ON appointments.client_id = clients.id
                INNER JOIN appointment_services ON appointments.id = appointment_services.appointment_id
                GROUP BY appointments.id, clients.id, clients.first_name, clients.last_name, appointments.appointment_date, appointments.appointment_time, appointments.notes
                ORDER BY appointments.appointment_date DESC, appointments.appointment_time DESC
            ";


                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["transaction_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["patient_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["first_name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["last_name"]) . "</td>";

                            echo "<td>₱" . number_format($row["charge_amount"], 2) . "</td>";
                            echo "<td>₱" . number_format($row["amount_paid"], 2) . "</td>";
                            echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["time"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["notes"]) . "</td>";
                            echo "<td>
                            <button class='btn btn-primary'>View</button>
                                    <button class='btn btn-secondary'>Add Payment</button>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No records found.</td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>