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
                        <th>Appointment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
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
                        <td>
                            <?= $appointment['appointment_status'] == 0 ? 'Pending' : ($appointment['appointment_status'] == 1 ? 'Confirmed' : 'Completed') ?>
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
<div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAppointmentLabel">Edit Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAppointmentForm">
                    <input type="hidden" id="appointmentId" name="appointment_id">
                    <div class="mb-3">
                        <label for="editAppointmentDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editAppointmentDate" name="appointment_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAppointmentTime" class="form-label">Time</label>
                        <input type="time" class="form-control" id="editAppointmentTime" name="appointment_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="editNotes" name="notes" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-control" id="editStatus" name="status">
                            <option value="0">Pending</option>
                            <option value="1">Confirmed</option>
                            <option value="2">Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editAppointment(appointmentId) {
    // Fetch appointment data
    fetch(`controller/get_appointment.php?appointment_id=${appointmentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const appointment = data.appointment;
                document.getElementById('appointmentId').value = appointment.id;
                document.getElementById('editAppointmentDate').value = appointment.date;
                document.getElementById('editAppointmentTime').value = appointment.time;
                document.getElementById('editNotes').value = appointment.notes;
                document.getElementById('editStatus').value = appointment.status;
                new bootstrap.Modal(document.getElementById('editAppointmentModal')).show();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load appointment details.'
            });
        });
}

document.getElementById('editAppointmentForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('controller/update_appointment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message
            }).then(() => location.reload());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to update appointment.'
        });
    });
});
</script>
