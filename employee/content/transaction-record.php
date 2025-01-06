<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">System Activity</h6>
        <button class="btn btn-success" data-toggle="modal" data-target="#createAccountModal">Create Account</button>
    </div>
    <div class="card-body">

        <!-- Create Account Modal -->
        <div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="createAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAccountModalLabel">Create Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createAccountForm">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Employee">Employee</option>
                     
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="createAccount()">Create Account</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Modal -->
        <div class="modal fade" id="updateAccountModal" tabindex="-1" role="dialog" aria-labelledby="updateAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateAccountModalLabel">Update Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateAccountForm">
                            <input type="hidden" id="updateAccountId">
                            <div class="form-group">
                                <label for="updateFirstName">First Name</label>
                                <input type="text" class="form-control" id="updateFirstName" required>
                            </div>
                            <div class="form-group">
                                <label for="updateLastName">Last Name</label>
                                <input type="text" class="form-control" id="updateLastName" required>
                            </div>
                            <div class="form-group">
                                <label for="updateEmail">Email</label>
                                <input type="email" class="form-control" id="updateEmail" required>
                            </div>
                            <div class="form-group">
                                <label for="updatePassword">Password</label>
                                <input type="password" class="form-control" id="updatePassword" required>
                            </div>
                            <div class="form-group">
                                <label for="updateRole">Role</label>
                                <select class="form-control" id="updateRole" required>
                                    <option value="Admin">Admin</option>
               
                                    <option value="Employee">Employee</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirmUpdateButton">Update Account</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this account?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Confirm Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="fw-semibold fs-6">
                    <tr>
                        <th>Transaction ID</th>
                        <th>Patient ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Charge Amount</th>
                        <th>Amount Paid</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>101</td>
                        <td>John</td>
                        <td>Doe</td>
                        <td>$200.00</td>
                        <td>$150.00</td>
                        <td>2023-10-01</td>
                        <td>10:00 AM</td>
                        <td>No notes</td>
                        <td><button class="btn btn-primary">Edit</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>102</td>
                        <td>Jane</td>
                        <td>Smith</td>
                        <td>$300.00</td>
                        <td>$250.00</td>
                        <td>2023-10-02</td>
                        <td>11:00 AM</td>
                        <td>Follow-up required</td>
                        <td><button class="btn btn-primary">Edit</button></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>103</td>
                        <td>Emily</td>
                        <td>Johnson</td>
                        <td>$150.00</td>
                        <td>$150.00</td>
                        <td>2023-10-03</td>
                        <td>12:00 PM</td>
                        <td>Paid in full</td>
                        <td><button class="btn btn-primary">Edit</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showUpdateModal(accountId, firstName, lastName, email, password, role) {
        document.getElementById('updateAccountId').value = accountId;
        document.getElementById('updateFirstName').value = firstName;
        document.getElementById('updateLastName').value = lastName;
        document.getElementById('updateEmail').value = email;
        document.getElementById('updatePassword').value = password;
        document.getElementById('updateRole').value = role;
        $('#updateAccountModal').modal('show');
    }

    document.getElementById('confirmUpdateButton').addEventListener('click', function() {
        const accountId = document.getElementById('updateAccountId').value;
        const firstName = document.getElementById('updateFirstName').value;
        const lastName = document.getElementById('updateLastName').value;
        const email = document.getElementById('updateEmail').value;
        const password = document.getElementById('updatePassword').value;
        const role = document.getElementById('updateRole').value;

        updateAccount(accountId, firstName, lastName, email, password, role); // Call the update function with the account details
        $('#updateAccountModal').modal('hide'); // Hide the modal after confirmation
    });

    function showDeleteConfirmation(accountId) {
        document.getElementById('confirmDeleteButton').setAttribute('data-account-id', accountId);
        $('#deleteConfirmationModal').modal('show');
    }

    document.getElementById('confirmDeleteButton').addEventListener('click', function() {
        const accountId = this.getAttribute('data-account-id');
        deleteAccount(accountId); // Call the delete function with the account ID
        $('#deleteConfirmationModal').modal('hide'); // Hide the modal after confirmation
    });
</script>