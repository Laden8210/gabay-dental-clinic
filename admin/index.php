<?php


$title = "Gabay Dental Clinic";


$view = isset($_GET['view']) ? $_GET['view'] : 'Home';

$content = 'content/dashboard.php';

switch ($view) {
    case 'Home':
        $title = "Dashboard";

        $content = 'content/dashboard.php';
        break;

    case 'appointment-list':
        $title = "Appointment List";
        $content = 'content/appointment-list.php';
        break;
    case 'appointment-request':
        $title = "Appointment Request";
        $content = 'content/appointment-request.php';
        break;

    case 'create-appointment':
        $title = "Create Appointment";
        $content = 'content/create-appointment.php';
        break;

    case 'patient-record':
        $title = "Patient Record";
        $content = 'content/patient-record.php';
        break;

    case 'transaction-record':
        $title = "Transaction Record";
        $content = 'content/transaction-record.php';
        break;

    case 'system-log':
        $title = "System Log";
        $content = 'content/system-log.php';
        break;

    case 'account-management':
        $title = "Account Management";
        $content = 'content/account-management.php';
        break;

    default:
        $content = 'content/dashboard.php';
        break;
}


require_once 'template/app.php';
