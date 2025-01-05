<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Appointment List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="fw-semibold fs-6">
                    <tr>
                        <th>Request ID</th>
                        <th>Patient ID</th>
                        <th>First Name</th>
                        <th>Mobile Number</th>
                        <th>Patient Status</th>
                        <th>Services</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Notes</th>
                        <th>Appointment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>101</td>
                        <td>John</td>
                        <td>1234567890</td>
                        <td>Active</td>
                        <td>Consultation</td>
                        <td>2023-10-01</td>
                        <td>10:00 AM</td>
                        <td>No notes</td>
                        <td>Confirmed</td>

                        <td><button class="btn btn-primary btn-circle"><i class="fa fa-edit" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>102</td>
                        <td>Jane</td>
                        <td>0987654321</td>
                        <td>Inactive</td>
                        <td>Follow-up</td>
                        <td>2023-10-02</td>
                        <td>11:00 AM</td>
                        <td>Follow-up needed</td>
                        <td>Pending</td>
                        <td><button class="btn btn-primary btn-circle"><i class="fa fa-edit" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>