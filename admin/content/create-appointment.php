<?php

require_once '../config/config.php';

$stmt = $conn->prepare("SELECT * FROM services");
$stmt->execute();
$services = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();


$stmt = $conn->prepare("SELECT id, first_name, last_name FROM clients");
$stmt->execute();
$clients = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();


?>

<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Appointment</h6>
    </div>
    <div class="card-body">

        <form method="POST" class="needs-validation" novalidate>
            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="client">Select Client</label>
                        <select class="form-control" id="clientType" name="client_id">
                            <option value="">Choose a client or add a new one</option>
                            <?php foreach ($clients as $client) : ?>
                                <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) ?></option>
                            <?php endforeach; ?>
                        </select>

                        <small class="form-text text-muted">Select an existing client from the list or leave blank to add a new client.</small>
                        <div class="invalid-feedback">Please select a client or add a new one.</div>
                    </div>


                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter first name" required>
                        <div class="invalid-feedback">Please provide a valid first name.</div>
                    </div>

                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter last name" required>
                        <div class="invalid-feedback">Please provide a valid last name.</div>
                    </div>

                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" name="age" placeholder="Enter age" required>
                        <div class="invalid-feedback">Please provide a valid age.</div>
                    </div>

                    <div class="form-group">
                        <label for="sex">Sex</label>
                        <select class="form-control" id="sex" name="sex" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="invalid-feedback">Please select a valid option.</div>
                    </div>
                    <div class="form-group">
                        <label for="mobileNumber">Mobile Number</label>
                        <input type="tel" class="form-control" id="mobileNumber" name="mobile_number" placeholder="Enter mobile number" pattern="[0-9]{10}" required>
                        <div class="invalid-feedback">Please provide a valid 10-digit mobile number.</div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                        <div class="invalid-feedback">Please provide a valid email address.</div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address" required></textarea>
                        <div class="invalid-feedback">Please provide a valid address.</div>
                    </div>

                    <div class="form-group">
                        <label for="occupation">Occupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Enter occupation" required>
                        <div class="invalid-feedback">Please provide a valid occupation.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="appointmentDate">Appointment Date</label>
                        <input type="date" class="form-control" id="appointmentDate" name="appointment_date" required>
                        <div class="invalid-feedback">Please provide a valid appointment date.</div>
                    </div>

                    <div class="form-group">
                        <label for="appointmentTime">Appointment Time</label>
                        <input type="time" class="form-control" id="appointmentTime" name="appointment_time" required>
                        <div class="invalid-feedback">Please provide a valid appointment time.</div>
                    </div>

                    <div class="form-group">
                        <label for="address">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Enter Note"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <hr>

                    <div>
                        <h6 class="m-0 font-weight-bold text-primary">Service</h6>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Service Name</th>
                                    <th>Price</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($services as $service) : ?>
                                    <tr>
                                        <td>
                                            <div class="form-check"><input type="checkbox" class="form-check-input" name="services[]" value="<?= $service['id'] ?>">
                                            </div>
                                        </td>
                                        <td><?= $service['name'] ?></td>
                                        <td>₱<?= $service['price'] ?></td>

                                    </tr>
                                <?php endforeach; ?>


                            </tbody>
                        </table>

                    </div>
                </div>
        </form>

        <script>
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();

            document.querySelector('form').addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this);

                fetch('controller/save_appointment.php', {
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
                            }).then(() => {
                                location.href = 'index.php?page=appointment-list';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while saving the appointment.'
                        });
                    });
            });


            document.getElementById('clientType').addEventListener('change', function() {
                const clientId = this.value;

                if (clientId) {
                    fetch('controller/get_client.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                client_id: clientId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                const client = data.client;


                                document.getElementById('firstName').value = client.first_name || '';
                                document.getElementById('lastName').value = client.last_name || '';
                                document.getElementById('age').value = client.age || '';
                                document.getElementById('sex').value = client.sex || '';
                                document.getElementById('mobileNumber').value = client.mobile_number || '';
                                document.getElementById('email').value = client.email || '';
                                document.getElementById('address').value = client.address || '';
                                document.getElementById('occupation').value = client.occupation || '';
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message
                                });

                                // Clear the form if client not found
                                clearClientForm();
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while fetching client information.'
                            });

                            // Clear the form on error
                            clearClientForm();
                        });
                } else {
                    // Clear the form if no client is selected
                    clearClientForm();
                }
            });

            // Function to clear the client form
            function clearClientForm() {
                document.getElementById('firstName').value = '';
                document.getElementById('lastName').value = '';
                document.getElementById('age').value = '';
                document.getElementById('sex').value = '';
                document.getElementById('mobileNumber').value = '';
                document.getElementById('email').value = '';
                document.getElementById('address').value = '';
                document.getElementById('occupation').value = '';
            }
        </script>

    </div>
</div>