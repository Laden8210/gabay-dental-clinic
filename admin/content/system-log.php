<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">System Activity</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- The table ID #dataTables is used by DataTables -->
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                <thead class="fw-semibold fs-6">
                    <tr>
                        <th>Log ID</th>
                        <th>User</th>
                        <th>Activity</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query: fetch system logs, join with users table, descending by created_at
                    $sql = "
                        SELECT 
                            system_logs.id AS log_id, 
                            CONCAT(users.first_name, ' ', users.last_name) AS user, 
                            system_logs.activity, 
                            DATE_FORMAT(system_logs.created_at, '%b %e, %Y') AS date, 
                            DATE_FORMAT(system_logs.created_at, '%h:%i %p') AS time
                        FROM system_logs
                        JOIN users ON system_logs.user_id = users.id
                        ORDER BY system_logs.created_at DESC
                    ";

                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row['log_id'] . "</td>
                                    <td>" . $row['user'] . "</td>
                                    <td>" . $row['activity'] . "</td>
                                    <td>" . $row['date'] . "</td>
                                    <td>" . $row['time'] . "</td>
                                 </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No Record Found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables').DataTable({
            "ordering": false 
        });
    });
</script>