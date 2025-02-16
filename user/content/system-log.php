<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">System Activity</h6>

    </div>
    <div class="card-body">


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                    $sql = "SELECT * FROM system_logs";
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
                        echo "<tr> <td colspan='5'> No Record Found </td> </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>