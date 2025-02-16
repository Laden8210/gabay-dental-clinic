<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Patient Record</h6>

    </div>
    <div class="card-body">


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
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
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
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
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
                                </div>

                                <!-- Full Width (New ID Picture Upload) -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateIdPicture">Upload New ID Picture</label>
                                        <input type="file" class="form-control" id="updateIdPicture" accept="image/*">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateProfilePicture">Upload New Profile Picture</label>
                                        <input type="file" class="form-control" id="updateProfilePicture" accept="image/*">
                                    </div>

                                </div>

                                <div class="col-12 d-flex justify-content-end gap-1 align-content-center">
                                    <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="confirmUpdateButton">Update Account</button>
                                </div>

                            </div>

                        </form>
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
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-auto rounded-circle border" style="width: 150px; height: 150px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            <img src="" id="viewIDProfile" alt="ID Profile" class="img-fluid w-100 h-100 object-fit-cover" />
                        </div>


                        <div id="viewAccountDetails"></div>
                        <img id="viewIdPicture" src="" alt="ID Picture" class="img-fluid" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <?php
                    $sql = "SELECT * FROM clients";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $client_id = $row['id'];

                            // Query to calculate total service fee
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

                            // Query to calculate total payments made
                            $payment_sql = "SELECT COALESCE(SUM(amount_paid), 0) AS total_paid 
                            FROM payments AS p
                            JOIN appointments AS a ON p.appointment_id = a.id
                            WHERE a.client_id = ?";
                            $payment_stmt = $conn->prepare($payment_sql);
                            $payment_stmt->bind_param("i", $client_id);
                            $payment_stmt->execute();
                            $payment_result = $payment_stmt->get_result();
                            $payment_row = $payment_result->fetch_assoc();
                            $total_paid = $payment_row['total_paid'];

                            // Calculate the balance dynamically
                            $balance = $total_cost - $total_paid;

                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['sex']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['mobile_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['occupation']) . "</td>";
                            echo "<td>₱" . number_format($balance, 2) . "</td>"; 
                            $statusBadge = ($row['status'] == 0) ?
                                "<span class='badge bg-success'>Active</span>" :
                                "<span class='badge bg-danger'>Inactive</span>";
                            echo "<td>{$statusBadge}</td>";

                            echo "<td class='d-flex justify-content-normal'>";
                            echo "<button class='btn btn-primary mx-1' onclick='showUpdateModal(" . $row['id'] . ", \"" .
                                addslashes($row['first_name']) . "\", \"" . addslashes($row['last_name']) . "\", " .
                                $row['age'] . ", \"" . $row['sex'] . "\", \"" . addslashes($row['mobile_number']) . "\", \"" .
                                addslashes($row['email']) . "\", \"" . addslashes($row['address']) . "\", \"" .
                                addslashes($row['occupation']) . "\")'>
                <i class='fa fa-edit' aria-hidden='true'></i>
            </button>";

                            $statusButtonClass = ($row['status'] == 0) ? 'btn-success' : 'btn-secondary';
                            $statusIcon = ($row['status'] == 0) ? 'fa-toggle-on' : 'fa-toggle-off';

                            echo "<button class='btn " . ($row['status'] == 1 ? "btn-success" : "btn-secondary") . "' 
            onclick='showUpdateStatusModal(" . $row['id'] . ", " . $row['status'] . ")'>
            <i class='fa fa-toggle-on' aria-hidden='true'></i>
            </button>";

                            echo "<button class='btn btn-danger mx-1' onclick='showDeleteConfirmation(" . $row['id'] . ")'>
                <i class='fa fa-trash' aria-hidden='true'></i>
            </button>";

                            echo "<button class='btn btn-info' onclick='showViewModal(" . $row['id'] . ", \"" .
                                addslashes($row['first_name']) . "\", \"" . addslashes($row['last_name']) . "\", " .
                                $row['age'] . ", \"" . $row['sex'] . "\", \"" . addslashes($row['mobile_number']) . "\", \"" .
                                addslashes($row['email']) . "\", \"" . addslashes($row['address']) . "\", \"" .
                                addslashes($row['occupation']) . "\", \"₱" . number_format($balance, 2) . "\", \"" . $row['status'] . "\", \"" .
                                addslashes($row['profile_picture']) . "\", \"" . addslashes($row['id_picture']) . "\")'>
                <i class='fa fa-eye' aria-hidden='true'></i>
            </button>";

                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11' class='text-center'>No records found</td></tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>


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
                        <label for=" status">Status</label>
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


    function showUpdateStatusModal(accountId, status) {
        document.getElementById('statusAccountId').value = accountId;
        document.getElementById('status').value = status;

        $('#updateStatusModal').modal('show');
    }

    function showUpdateStatusModal(accountId, currentStatus) {
        document.getElementById("statusAccountId").value = accountId;
        document.getElementById("status").value = (currentStatus == 1) ? "Active" : "Inactive";
        $("#updateStatusModal").modal("show");
    }

    document.getElementById('confirmStatusUpdateButton').addEventListener('click', function() {
        const accountId = document.getElementById('statusAccountId').value;
        const status = document.getElementById('status').value;

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to update this account status?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('controller/update-status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            account_id: accountId,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated',
                                text: data.message
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred. Please try again later.', 'error');
                    });
            }
        });
    });

    document.getElementById("confirmUpdateButton").addEventListener("click", function() {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to update this account?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!"
        }).then((result) => {
            if (result.isConfirmed) {
                updateClient();
            }
        });
    });

    function updateClient() {
        let formData = new FormData();
        formData.append("id", document.getElementById("updateAccountId").value);
        formData.append("first_name", document.getElementById("updateFirstName").value);
        formData.append("last_name", document.getElementById("updateLastName").value);
        formData.append("age", document.getElementById("updateAge").value);
        formData.append("sex", document.getElementById("updateSex").value);
        formData.append("mobile_number", document.getElementById("updateMobileNumber").value);
        formData.append("email", document.getElementById("updateEmail").value);
        formData.append("address", document.getElementById("updateAddress").value);
        formData.append("occupation", document.getElementById("updateOccupation").value);

        let profilePic = document.getElementById("updateProfilePicture").files[0];
        let idPic = document.getElementById("updateIdPicture").files[0];

        if (profilePic) {
            formData.append("profile_picture", profilePic);
        }
        if (idPic) {
            formData.append("id_picture", idPic);
        }

        fetch("controller/update_client.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire("Updated!", "Client has been updated.", "success").then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire("Error!", data.message, "error");
                }
            })
            .catch(error => {
                Swal.fire("Error!", "Something went wrong.", "error");
                console.error("Error:", error);
            });
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
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('controller/delete-account.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            patient_id: accountId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: data.message
                            }).then(() => {
                                location.reload();
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'An error occurred. Please try again later.',
                            'error'
                        );
                    });
            }
        });
    }

    document.getElementById('confirmDeleteButton').addEventListener('click', function() {
        const accountId = this.getAttribute('data-account-id');
        deleteAccount(accountId);
        $('#deleteConfirmationModal').modal('hide');
    });

    function showViewModal(accountId, firstName, lastName, age, sex, mobileNumber, email, address, occupation, balance, status, profilePicture, idPicture) {
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
    `;

        let statusBadge = status == 0 ?
            "<span class='badge bg-success'>Active</span>" :
            "<span class='badge bg-danger'>Inactive</span>";

        document.getElementById("viewAccountDetails").innerHTML = details + `<p><strong>Status:</strong> ${statusBadge}</p>`;
        document.getElementById("viewIDProfile").src = "../uploads/" + profilePicture;
        document.getElementById("viewIdPicture").src = "../uploads/" + idPicture;


        // Show the modal
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