<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Account List</h6>
        <button class="btn btn-success" data-toggle="modal" data-target="#createUserAccount">Add Account</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="fw-semibold fs-6">
                    <tr>
                        <th>Account ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $sql = "SELECT * FROM users";
                    $result = mysqli_query($conn, $sql);


                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['first_name'] . "</td>
                                    <td>" . $row['last_name'] . "</td>
                                    <td>" . $row['email'] . "</td>
                                    <td>" . $row['password'] . "</td>
                                    <td>" . $row['role'] . "</td>
                                    <td>
                                        <a href='admin/content/account-management.php?edit=" . $row['id'] . "' class='btn btn-primary btn-circle btn-sm'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                        <a href='admin/content/account-management.php?delete=" . $row['id'] . "' class='btn btn-danger btn-circle btn-sm'>
                                            <i class='fas fa-trash'></i>
                                        </a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr> <td colspan='7'> No Record Found </td> </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Create Service Modal -->
<div class="modal fade" id="createUserAccount" tabindex="-1" role="dialog" aria-labelledby="createServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createServiceModalLabel">Add New Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="add_account">Add Account</button>
            </div>
        </div>
    </div>