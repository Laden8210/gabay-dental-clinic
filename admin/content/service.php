<?php
require_once '../config/config.php';

// Fetch data
$stmt = $conn->prepare("SELECT * FROM services");
$stmt->execute();
$services = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<div class="card shadow mb-4">
    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Service List</h6>
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
                                    <!-- UPDATE BUTTON -->
                                    <button class="btn btn-warning btn-sm"
                                            data-toggle="modal"
                                            data-target="#updateServiceModal"
                                            data-id="<?php echo $service['id']; ?>"
                                            data-name="<?php echo htmlspecialchars($service['name']); ?>"
                                            data-description="<?php echo htmlspecialchars($service['description']); ?>"
                                            data-price="<?php echo $service['price']; ?>">
                                        Update
                                    </button>
                                    <!-- DELETE BUTTON -->
                                    <button class="btn btn-danger btn-sm" onclick="deleteService(<?php echo $service['id']; ?>)">
                                        Delete
                                    </button>
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

<!-- CREATE SERVICE MODAL -->
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

<!-- UPDATE SERVICE MODAL -->
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
                    <!-- HIDDEN ID FIELD -->
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
// Wrap in jQuery document.ready to ensure elements are loaded
$(document).ready(function() {

    // CREATE SERVICE
    $('#saveService').on('click', function() {
        var formData = new FormData(document.getElementById('createServiceForm'));
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

    // TRIGGER UPDATE MODAL + PREFILL FIELDS
    $('#updateServiceModal').on('show.bs.modal', function(event) {
        var button     = $(event.relatedTarget);
        var id         = button.data('id');
        var name       = button.data('name');
        var desc       = button.data('description');
        var price      = button.data('price');

        $('#updateServiceId').val(id);
        $('#updateServiceName').val(name);
        $('#updateServiceDescription').val(desc);
        $('#updateServicePrice').val(price);
    });

    // UPDATE SERVICE
    $('#updateService').on('click', function() {
        var formData = new FormData(document.getElementById('updateServiceForm'));

        // Debug check – see if ID is present
        // for (var pair of formData.entries()) {
        //     console.log(pair[0]+ ': ' + pair[1]);
        // }

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

});

// DELETE SERVICE
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
