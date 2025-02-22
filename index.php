<?php


$title = "Gabay Dental Clinic";


$view = isset($_GET['view']) ? $_GET['view'] : 'Home';

$content = 'home.php';

switch ($view) {
    case 'Home':
        $content = 'home.php';
        break;

    case 'login':
        $content = 'login.php';
        break;



    default:
        $content = 'home.php';
        break;
}


require_once 'template/app.php';
