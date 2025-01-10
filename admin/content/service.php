<?php

require_once '../config/config.php';

$stmt = $conn->prepare("SELECT * FROM services");
$stmt->execute();
$services = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>
<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">System Activity</h6>
        <button class="btn btn-success" data-toggle="modal" data-target="#createServiceModal">Add Service</button>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="fw-semibold fs-6">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)) : ?>
                        <?php foreach ($services as $service) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($service['id']); ?></td>
                                <td><?php echo htmlspecialchars($service['name']); ?></td>
                                <td><?php echo htmlspecialchars($service['description']); ?></td>
                                <td><?php echo htmlspecialchars($service['price']); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateServiceModal" data-id="<?php echo $service['id']; ?>" data-name="<?php echo $service['name']; ?>" data-description="<?php echo $service['description']; ?>" data-price="<?php echo $service['price']; ?>">Update</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteService(<?php echo $service['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">No services found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Service Modal -->
<div class="modal fade" id="createServiceModal" tabindex="-1" role="dialog" aria-labelledby="createServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createServiceModalLabel">Add New Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createServiceForm">
                    <div class="form-group">
                        <label for="newServiceName">Service Name</label>
                        <input type="text" class="form-control" id="newServiceName" name="service_name" required>
                    </div>
                    <div class="form-group">
                        <label for="newServiceDescription">Description</label>
                        <textarea class="form-control" id="newServiceDescription" name="service_description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="newServicePrice">Price</label>
                        <input type="number" class="form-control" id="newServicePrice" name="service_price" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="saveService">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Service Modal -->
<div class="modal fade" id="updateServiceModal" tabindex="-1" role="dialog" aria-labelledby="updateServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateServiceModalLabel">Update Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateServiceForm">
                    <input type="hidden" id="updateServiceId" name="service_id">
                    <div class="form-group">
                        <label for="updateServiceName">Service Name</label>
                        <input type="text" class="form-control" id="updateServiceName" name="service_name" required>
                    </div>
                    <div class="form-group">
                        <label for="updateServiceDescription">Description</label>
                        <textarea class="form-control" id="updateServiceDescription" name="service_description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="updateServicePrice">Price</label>
                        <input type="number" class="form-control" id="updateServicePrice" name="service_price" required>
                    </div>
                    <button type="button" class="btn btn-primary" id="updateService">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('saveService').addEventListener('click', function() {
        const formData = new FormData(document.getElementById('createServiceForm'));
        fetch('controller/save_service.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Service Added',
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
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while saving the service.'
            });
        });
    });

    document.getElementById('updateServiceModal').addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const description = button.getAttribute('data-description');
        const price = button.getAttribute('data-price');

        document.getElementById('updateServiceId').value = id;
        document.getElementById('updateServiceName').value = name;
        document.getElementById('updateServiceDescription').value = description;
        document.getElementById('updateServicePrice').value = price;
    });

    document.getElementById('updateService').addEventListener('click', function() {
        const formData = new FormData(document.getElementById('updateServiceForm'));
        fetch('controller/update_service.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Service Updated',
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
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating the service.'
            });
        });
    });

    function deleteService(serviceId) {
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
                fetch('controller/delete_service.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: serviceId })
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
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while deleting the service.'
                    });
                });
            }
        });
    }
</script>
