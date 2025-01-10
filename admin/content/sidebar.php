<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">

        <div class="sidebar-brand-text mx-3">Gabay Dental Clinic</div>
    </a>


    <hr class="sidebar-divider my-0">


    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Appointment</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Appointment</h6>
                <a class="collapse-item" href="index.php?view=appointment-list">Appointment List</a>
                <a class="collapse-item" href="index.php?view=appointment-request">Appointment Request</a>
                <a class="collapse-item" href="index.php?view=create-appointment">Create New Appointment</a>
            </div>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Record</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Record</h6>
                <a class="collapse-item" href="index.php?view=patient-record">Patient</a>
                <a class="collapse-item" href="index.php?view=transaction-record">Transaction</a>
            </div>
        </div>
    </li>


    
    <li class="nav-item active">
        <a class="nav-link" href="index.php?view=service">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Service</span></a>
    </li>



    <li class="nav-item active">
        <a class="nav-link" href="index.php?view=account-management">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Account Management</span></a>
    </li>



    <li class="nav-item active">
        <a class="nav-link" href="index.php?view=system-log">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>System Log</span></a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" href="../logout.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Logout</span></a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

