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
                        <h5 class="modal-title" id="createAccountModalLabel">Create New Account</h5>
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
                        <h5 class="modal-title" id="updateAccountModalLabel">Update Account</h5>
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
                    <tr>
                        <td>1</td>
                        <td>John</td>
                        <td>Doe</td>
                        <td>john.doe@example.com</td>
                        <td>password123</td>
                        <td>Admin</td>
                        <td>
                            <button class="btn btn-primary btn-circle" onclick="showUpdateModal(1, 'John', 'Doe', 'john.doe@example.com', 'password123', 'Admin')"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button class="btn btn-danger btn-circle" onclick="showDeleteConfirmation(1)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane</td>
                        <td>Smith</td>
                        <td>jane.smith@example.com</td>
                        <td>password456</td>
                        <td>Employee</td>
                        <td>
                            <button class="btn btn-primary btn-circle" onclick="showUpdateModal(2, 'Jane', 'Smith', 'jane.smith@example.com', 'password456', 'User')"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button class="btn btn-danger btn-circle" onclick="showDeleteConfirmation(2)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Emily</td>
                        <td>Johnson</td>
                        <td>emily.johnson@example.com</td>
                        <td>password789</td>
                        <td>Employee</td>
                        <td>
                            <button class="btn btn-primary btn-circle" onclick="showUpdateModal(3, 'Emily', 'Johnson', 'emily.johnson@example.com', 'password789', 'Editor')"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button class="btn btn-danger btn-circle" onclick="showDeleteConfirmation(3)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <!-- Additional rows can be added here -->
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