<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'u278537438_gabay_dental');
define('DB_PASSWORD', 'Gabay8210');
define('DB_NAME', 'u278537438_gabay_dental');


try {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("ERROR: Could not connect. " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo $e;
}
