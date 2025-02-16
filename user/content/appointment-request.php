<?php

require_once '../config/config.php';

// Fetch all appointment data with associated client and service details
$stmt = $conn->prepare("
    SELECT 
        appointments.id AS appointment_id,
        clients.id AS client_id,
        clients.first_name,
        clients.last_name,
        clients.mobile_number,
        clients.status AS client_status,
        GROUP_CONCAT(services.name SEPARATOR ', ') AS services,
        appointments.appointment_date,
        appointments.appointment_time,
        appointments.notes,
        appointments.status AS appointment_status
    FROM appointments
    INNER JOIN clients ON appointments.client_id = clients.id
    INNER JOIN appointment_services ON appointments.id = appointment_services.appointment_id
    INNER JOIN services ON appointment_services.service_id = services.id
    WHERE appointments.status = 0
    GROUP BY appointments.id
");

$stmt->execute();
$appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>


<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Appointment List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="fw-semibold fs-6">
                    <tr>
                        <th>Request ID</th>
                        <th>Patient ID</th>
                        <th>First Name</th>
                        <th>Mobile Number</th>
                        <th>Patient Status</th>
                        <th>Services</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Notes</th>
                        <th>Service Fee</th>
                        <th>Appointment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($appointments as $appointment):
                        $client_id = $appointment['client_id'];

                        $service_sql = "SELECT COALESCE(SUM(amount), 0) AS total_cost 
                        FROM appointment_services AS ps
                        JOIN appointments AS a ON ps.appointment_id = a.id
                        WHERE a.client_id = ?";
                        $service_stmt = $conn->prepare($service_sql);
                        $service_stmt->bind_param("i", $client_id);
                        $service_stmt->execute();
                        $service_result = $service_stmt->get_result();
                        $service_row = $service_result->fetch_assoc();
                        $total_cost = $service_row['total_cost'];
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($appointment['appointment_id']) ?></td>
                            <td><?= htmlspecialchars($appointment['client_id']) ?></td>
                            <td><?= htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']) ?></td>
                            <td><?= htmlspecialchars($appointment['mobile_number']) ?></td>
                            <td><?= $appointment['client_status'] ? 'Active' : 'Inactive' ?></td>
                            <td><?= htmlspecialchars($appointment['services']) ?></td>
                            <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                            <td><?= htmlspecialchars($appointment['appointment_time']) ?></td>
                            <td><?= htmlspecialchars($appointment['notes']) ?></td>
                            <td>₱<?= number_format($total_cost, 2) ?></td>
    
                            <td>
                                <span class="badge 
    <?= $appointment['appointment_status'] == 0 ? 'bg-warning' : ($appointment['appointment_status'] == 1 ? 'bg-success' : 'bg-primary') ?>">
                                    <?= $appointment['appointment_status'] == 0 ? 'Pending' : ($appointment['appointment_status'] == 1 ? 'Confirmed' : 'Completed') ?>
                                </span>

                            </td>
                            <td>
                                <button class="btn btn-primary btn-circle" onclick="editAppointment(<?= $appointment['appointment_id'] ?>)">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>