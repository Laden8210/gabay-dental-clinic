<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Patient Record</h6>
        <button class="btn btn-success" data-toggle="modal" data-target="#createAccountModal">Create Account</button>
    </div>
    <div class="card-body">

        <!-- Create Account Modal -->
        <div class="modal fade" id="createAccountModal" tabindex="-1" role="dialog" aria-labelledby="createAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAccountModalLabel">Create New Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createAccountForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" required>
                            </div>
                            <div class="form-group">
                                <label for="sex">Sex</label>
                                <select class="form-control" id="sex" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="mobileNumber">Mobile Number</label>
                                <input type="text" class="form-control" id="mobileNumber" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" required>
                            </div>
                            <div class="form-group">
                                <label for="occupation">Occupation</label>
                                <input type="text" class="form-control" id="occupation" required>
                            </div>
                            <div class="form-group">
                                <label for="idPicture">Upload ID Picture</label>
                                <input type="file" class="form-control-file" id="idPicture" accept="image/*" required>
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateAccountModalLabel">Update Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateAccountForm" enctype="multipart/form-data">
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
                                <label for="updateAge">Age</label>
                                <input type="number" class="form-control" id="updateAge" required>
                            </div>
                            <div class="form-group">
                                <label for="updateSex">Sex</label>
                                <select class="form-control" id="updateSex" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="updateMobileNumber">Mobile Number</label>
                                <input type="text" class="form-control" id="updateMobileNumber" required>
                            </div>
                            <div class="form-group">
                                <label for="updateEmail">Email</label>
                                <input type="email" class="form-control" id="updateEmail" required>
                            </div>
                            <div class="form-group">
                                <label for="updateAddress">Address</label>
                                <input type="text" class="form-control" id="updateAddress" required>
                            </div>
                            <div class="form-group">
                                <label for="updateOccupation">Occupation</label>
                                <input type="text" class="form-control" id="updateOccupation" required>
                            </div>
                            <div class="form-group">
                                <label for="updateIdPicture">Upload New ID Picture</label>
                                <input type="file" class="form-control-file" id="updateIdPicture" accept="image/*">
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

        <!-- View Modal -->
        <div class="modal fade" id="viewAccountModal" tabindex="-1" role="dialog" aria-labelledby="viewAccountModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewAccountModalLabel">View Patient Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="viewAccountDetails"></div>
                        <img id="viewIdPicture" src="" alt="ID Picture" class="img-fluid" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateStatusButton" onclick="showUpdateStatusModal(${accountId})">Update Status</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Status Modal -->
        <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusModalLabel">Update Patient Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateStatusForm">
                            <input type="hidden" id="statusAccountId">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirmStatusUpdateButton">Update Status</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="fw-semibold fs-6">
                    <tr>
                        <th>Patient ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Mobile Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Occupation</th>
                        <th>Balance</th>
                        <th>Status</th>
    
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John</td>
                        <td>Doe</td>
                        <td>30</td>
                        <td>Male</td>
                        <td>(123) 456-7890</td>
                        <td>john.doe@example.com</td>
                        <td>123 Main St</td>
                        <td>Engineer</td>
                        <td>$1000</td>
                        <td>Active</td>
                        <td>
                            <button class="btn btn-primary btn-circle" onclick="showUpdateModal(1, 'John', 'Doe', 30, 'Male', '(123) 456-7890', 'john.doe@example.com', '123 Main St', 'Engineer')"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button class="btn btn-danger btn-circle" onclick="showDeleteConfirmation(1)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <button class="btn btn-info btn-circle" onclick="showViewModal(1, 'John', 'Doe', 30, 'Male', '(123) 456-7890', 'john.doe@example.com', '123 Main St', 'Engineer', '$1000', 'Active', 'path/to/id_picture.jpg')"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane</td>
                        <td>Smith</td>
                        <td>30</td>
                        <td>Female</td>
                        <td>(123) 456-7890</td>
                        <td>jane.smith@example.com</td>
                        <td>123 Main St</td>
                        <td>Doctor</td>
                        <td>$1000</td>
                        <td>Active</td>
                        <td>
                            <button class="btn btn-primary btn-circle" onclick="showUpdateModal(2, 'Jane', 'Smith', 30, 'Female', '(123) 456-7890', 'jane.smith@example.com', '123 Main St', 'Doctor')"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button class="btn btn-danger btn-circle" onclick="showDeleteConfirmation(2)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <button class="btn btn-info btn-circle" onclick="showViewModal(2, 'Jane', 'Smith', 30, 'Female', '(123) 456-7890', 'jane.smith@example.com', '123 Main St', 'Doctor', '$1000', 'Active', 'path/to/id_picture.jpg')"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Emily</td>
                        <td>Johnson</td>
                        <td>30</td>
                        <td>Female</td>
                        <td>(123) 456-7890</td>
                        <td>emily.johnson@example.com</td>
                        <td>123 Main St</td>
                        <td>Teacher</td>
                        <td>$1000</td>
                        <td>Active</td>
                        <td>
                            <button class="btn btn-primary btn-circle" onclick="showUpdateModal(3, 'Emily', 'Johnson', 30, 'Female', '(123) 456-7890', 'emily.johnson@example.com', '123 Main St', 'Teacher')"><i class="fa fa-edit" aria-hidden="true"></i></button>
                            <button class="btn btn-danger btn-circle" onclick="showDeleteConfirmation(3)"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <button class="btn btn-info btn-circle" onclick="showViewModal(3, 'Emily', 'Johnson', 30, 'Female', '(123) 456-7890', 'emily.johnson@example.com', '123 Main St', 'Teacher', '$1000', 'Active', 'path/to/id_picture.jpg')"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <!-- Additional rows can be added here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showUpdateModal(accountId, firstName, lastName, age, sex, mobileNumber, email, address, occupation) {
        document.getElementById('updateAccountId').value = accountId;
        document.getElementById('updateFirstName').value = firstName;
        document.getElementById('updateLastName').value = lastName;
        document.getElementById('updateAge').value = age;
        document.getElementById('updateSex').value = sex;
        document.getElementById('updateMobileNumber').value = mobileNumber;
        document.getElementById('updateEmail').value = email;
        document.getElementById('updateAddress').value = address;
        document.getElementById('updateOccupation').value = occupation;


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

    function showViewModal(accountId, firstName, lastName, age, sex, mobileNumber, email, address, occupation, balance, status, idPicture) {
        const details = `
            <p><strong>Patient ID:</strong> ${accountId}</p>
            <p><strong>First Name:</strong> ${firstName}</p>
            <p><strong>Last Name:</strong> ${lastName}</p>
            <p><strong>Age:</strong> ${age}</p>
            <p><strong>Sex:</strong> ${sex}</p>
            <p><strong>Mobile Number:</strong> ${mobileNumber}</p>
            <p><strong>Email:</strong> ${email}</p>
            <p><strong>Address:</strong> ${address}</p>
            <p><strong>Occupation:</strong> ${occupation}</p>
            <p><strong>Balance:</strong> ${balance}</p>
            <p><strong>Status:</strong> ${status}</p>
        `;
        document.getElementById('viewAccountDetails').innerHTML = details;
        document.getElementById('viewIdPicture').src = idPicture;
        
        // Store the accountId in a global variable or directly pass it to the button
        document.getElementById('updateStatusButton').setAttribute('data-account-id', accountId);
        
        $('#viewAccountModal').modal('show');
    }

    function showUpdateStatusModal(accountId) {
        document.getElementById('statusAccountId').value = accountId;
        $('#updateStatusModal').modal('show');
    }

    document.getElementById('confirmStatusUpdateButton').addEventListener('click', function() {
        const accountId = document.getElementById('statusAccountId').value;
        const status = document.getElementById('status').value;

        updateStatus(accountId, status); // Call the function to update the status
        $('#updateStatusModal').modal('hide'); // Hide the modal after confirmation
    });
</script>