<?php
require_once '../config/config.php';

// Fetch Total Transactions (Total amount from payments)
$totalTransactionsQuery = "SELECT SUM(amount_paid) AS total FROM payments WHERE status = 'Completed'";
$totalTransactionsResult = $conn->query($totalTransactionsQuery);
$totalTransactions = $totalTransactionsResult->fetch_assoc()['total'] ?? 0;

// Fetch Verified Patients (Total verified clients)
$verifiedPatientsQuery = "SELECT COUNT(*) AS total FROM clients WHERE status = 1";
$verifiedPatientsResult = $conn->query($verifiedPatientsQuery);
$verifiedPatients = $verifiedPatientsResult->fetch_assoc()['total'] ?? 0;

// Fetch Pending Appointments
$pendingAppointmentsQuery = "SELECT COUNT(*) AS total FROM appointments WHERE status = 0";
$pendingAppointmentsResult = $conn->query($pendingAppointmentsQuery);
$pendingAppointments = $pendingAppointmentsResult->fetch_assoc()['total'] ?? 0;

$grossIncomeQuery = "SELECT SUM(amount_paid) AS total FROM payments WHERE status = 'Completed'";
$grossIncomeResult = $conn->query($grossIncomeQuery);
$grossIncome = $grossIncomeResult->fetch_assoc()['total'] ?? 0;

$appointmentsQuery = "
    SELECT 
        appointments.id AS appointment_id,
        clients.first_name, 
        clients.mobile_number, 
        GROUP_CONCAT(services.name SEPARATOR ', ') AS services,
        appointments.appointment_date, 
        appointments.appointment_time, 
        appointments.notes, 
        appointments.status
    FROM appointments
    INNER JOIN clients ON appointments.client_id = clients.id
    INNER JOIN appointment_services ON appointments.id = appointment_services.appointment_id
    INNER JOIN services ON appointment_services.service_id = services.id
    WHERE appointments.status = 0 and appointments.appointment_date >= CURDATE()
    
    GROUP BY appointments.id
";
$appointmentsResult = $conn->query($appointmentsQuery);


$sql_area = "SELECT s.name, SUM(asrv.amount) AS amount_charged, SUM(p.amount_paid) AS amount_paid 
             FROM services s 
             LEFT JOIN appointment_services asrv ON asrv.service_id = s.id
             LEFT JOIN appointments app ON app.id = asrv.appointment_id
             LEFT JOIN payments p ON p.appointment_id = app.id
             GROUP BY s.name";
$result_area = $conn->query($sql_area);
$area_data = [];
while ($row = $result_area->fetch_assoc()) {
    $area_data[] = $row;
}


$sql_pie = "SELECT s.name, COUNT(asrv.service_id) AS service_count 
            FROM services s 
            LEFT JOIN appointment_services asrv ON asrv.service_id = s.id
            GROUP BY s.name";
$result_pie = $conn->query($sql_pie);
$pie_data = [];
while ($row = $result_pie->fetch_assoc()) {
    $pie_data[] = $row;
}

$sql_age = "SELECT age, COUNT(*) AS age_group_count FROM clients GROUP BY age";
$result_age = $conn->query($sql_age);
$age_data = [];
while ($row = $result_age->fetch_assoc()) {
    $age_data[] = $row;
}



?>

<div class="row gap-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Transactions</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?= number_format($totalTransactions, 2) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Verified Patients</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $verifiedPatients ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pending Appointments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pendingAppointments ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Gross Income</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?= number_format($grossIncome, 2) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave-alt  text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4 overflow-auto">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Income Per Month</h6>
               
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- Pie Chart -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Service Distribution</h6>

            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
           
            </div>
        </div>
    </div>




</div>


<!-- Appointment List Table -->
<div class="card shadow mb-4">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary">Appointment List | <span>Today</span></h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>

                        <th>First Name</th>
                        <th>Mobile Number</th>
                        <th>Services</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Notes</th>
                        <th>Appointment Status</th>

                    </tr>
                </thead>
                <tbody>
                    <?php while ($appointment = $appointmentsResult->fetch_assoc()): ?>
                        <tr>

                            <td><?= $appointment['first_name'] ?></td>
                            <td><?= $appointment['mobile_number'] ?></td>
                            <td><?= $appointment['services'] ?></td>
                            <td><?= $appointment['appointment_date'] ?></td>
                            <td><?= $appointment['appointment_time'] ?></td>
                            <td><?= $appointment['notes'] ?></td>
                            <td><?= $appointment['status'] == 1 ? 'Completed' : 'Pending' ?></td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>