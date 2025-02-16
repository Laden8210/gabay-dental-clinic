<?php
require_once '../config/config.php';

// Fetch appointment data with total service charge and payments
$stmt = $conn->prepare("SELECT 
    a.id AS appointment_id,
    c.id AS client_id,
    c.first_name,
    c.last_name,
    c.mobile_number,
    c.status AS client_status,
    GROUP_CONCAT(s.name SEPARATOR ', ') AS services,
    a.appointment_date,
    a.appointment_time,
    a.notes,
    a.status AS appointment_status,
    COALESCE(SUM(ps.amount), 0) AS total_service_charge,
    (SELECT COALESCE(SUM(p.amount_paid), 0) FROM payments p WHERE p.appointment_id = a.id and p.status = 'Completed') AS total_payment
FROM appointments a
INNER JOIN clients c ON a.client_id = c.id
INNER JOIN appointment_services ps ON a.id = ps.appointment_id
INNER JOIN services s ON ps.service_id = s.id
WHERE a.status != 0
GROUP BY a.id");

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
                        <th>Full Name</th>
                        <th>Mobile Number</th>
                        <th>Patient Status</th>
                        <th>Services</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Total Charge</th>
                        <th>Payments</th>
                        <th>Balance</th>
                        <th>Status</th>
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
                            <td><?= number_format($appointment['total_service_charge'], 2) ?></td>
                            <td><?= number_format($appointment['total_payment'], 2) ?></td>
                            <td><?= number_format($appointment['total_service_charge'] - $appointment['total_payment'], 2) ?></td>
                            <td>
                                <span class="badge <?= $appointment['appointment_status'] == 0 ? 'bg-warning' : ($appointment['appointment_status'] == 1 ? 'bg-success' : 'bg-primary') ?>">
                                    <?= $appointment['appointment_status'] == 0 ? 'Pending' : ($appointment['appointment_status'] == 1 ? 'Confirmed' : 'Completed') ?>
                                </span>
                            </td>
                            <td class="d-flex">
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModal" data-id="<?= $appointment['appointment_id'] ?>">
                                    <i class="fas fa-dollar-sign"></i>
                                </button>
                                <button class="btn btn-info btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#viewPaymentModal" data-id="<?= $appointment['appointment_id'] ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-primary btn-sm update-status-btn" data-bs-toggle="modal"
                                    data-bs-target="#updateStatusModal"
                                    data-id="<?= $appointment['appointment_id'] ?>"
                                    data-status="<?= $appointment['appointment_status'] ?>">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Payment Modal -->

<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentLabel">Add Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    <input type="hidden" id="appointment_id" name="appointment_id">

                    <div class="mb-3">
                        <label for="amount_paid" class="form-label">Amount Paid</label>
                        <input type="number" class="form-control" id="amount_paid" name="amount_paid" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="Cash">Cash</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Upload Proof (Optional)</label>
                        <input type="file" class="form-control" id="payment_proof" name="payment_proof">
                    </div>

                    <button type="submit" class="btn btn-success w-100">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- View Payment Modal -->
<div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPaymentLabel">Payment History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Proof</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="paymentTableBody">
                        <tr>
                            <td colspan="7" class="text-center">No payments found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusLabel">Update Appointment Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm">
                    <input type="hidden" id="update_appointment_id" name="appointment_id">

                    <div class="mb-3">
                        <label for="new_status" class="form-label">Select New Status</label>
                        <select class="form-control" id="new_status" name="status">

                            <option value="1">Confirmed</option>
                            <option value="2">Completed</option>
                            <option value="-1">Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Handle status update button clicks
        document.querySelectorAll(".update-status-btn").forEach((button) => {
            button.addEventListener("click", function() {
                let appointmentId = this.getAttribute("data-id");
                let currentStatus = this.getAttribute("data-status");

                document.getElementById("update_appointment_id").value = appointmentId;
                document.getElementById("new_status").value = currentStatus;
            });
        });

        // Handle form submission
        document.getElementById("updateStatusForm").addEventListener("submit", function(e) {
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);

            Swal.fire({
                title: "Are you sure?",
                text: "You are about to update the appointment status!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, update it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("controller/update_status.php", {
                            method: "POST",
                            body: formData,
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire("Success!", data.message, "success").then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire("Error!", data.message, "error");
                            }
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "error");
                        });
                }
            });
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll("[data-bs-target='#viewPaymentModal']").forEach(button => {
            button.addEventListener("click", function() {
                let appointmentId = this.getAttribute("data-id");

                fetch(`controller/fetch_payments.php?appointment_id=${appointmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        let tableBody = document.getElementById("paymentTableBody");
                        tableBody.innerHTML = "";

                        if (data.length > 0) {
                            data.forEach((payment, index) => {
                                tableBody.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>₱${parseFloat(payment.amount_paid).toFixed(2)}</td>
                                    <td>${payment.payment_method}</td>
                                    <td>${payment.payment_date}</td>
                                    <td>${payment.payment_proof ? `<a href="../uploads/${payment.payment_proof}" target="_blank">View</a>` : "No Proof"}</td>
                                    <td>
                                        <span class="badge ${getStatusClass(payment.status)}">${payment.status}</span>
                                    </td>
                                    <td>
                                        <select class="form-control status-dropdown" data-payment-id="${payment.id}">
                                            <option value="Pending" ${payment.status === "Pending" ? "selected" : ""}>Pending</option>
                                            <option value="Completed" ${payment.status === "Completed" ? "selected" : ""}>Completed</option>
                                            <option value="Failed" ${payment.status === "Failed" ? "selected" : ""}>Failed</option>
                                        </select>
                                    </td>
                                </tr>`;
                            });

                            // Add event listener for status change
                            document.querySelectorAll(".status-dropdown").forEach(select => {
                                select.addEventListener("change", function() {
                                    let paymentId = this.getAttribute("data-payment-id");
                                    let newStatus = this.value;

                                    Swal.fire({
                                        title: "Are you sure?",
                                        text: `Update payment status to ${newStatus}?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonText: "Yes, update it!",
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            updatePaymentStatus(paymentId, newStatus);
                                        }
                                    });
                                });
                            });

                        } else {
                            tableBody.innerHTML = `<tr><td colspan="7" class="text-center">No payments found.</td></tr>`;
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Unable to fetch payment data!"
                        });
                    });
            });
        });
    });

    function getStatusClass(status) {
        switch (status) {
            case "Completed":
                return "bg-success";
            case "Pending":
                return "bg-warning";
            case "Failed":
                return "bg-danger";
            default:
                return "bg-secondary";
        }
    }

    function updatePaymentStatus(paymentId, newStatus) {
        fetch("controller/update_payment_status.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    payment_id: paymentId,
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Success!", data.message, "success").then(() => {
                       window.location.reload();
                    });
                } else {
                    Swal.fire("Error!", data.message, "error");
                }
            })
            .catch(() => {
                Swal.fire("Error!", "Something went wrong!", "error");
            });
    }


    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("paymentForm").addEventListener("submit", function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch("controller/process_payment.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Payment Successful",
                            text: "The payment has been recorded!",

                            timer: 2000
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Payment Failed",
                            text: data.message || "Something went wrong. Try again!"
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Unable to process payment!"
                    });
                });
        });

        document.querySelectorAll("[data-bs-target='#addPaymentModal']").forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("appointment_id").value = this.getAttribute("data-id");
            });
        });
    });
</script>