<?php
    require_once('../database.php');

    DATABASE::connect('localhost', 'smartparking', '123456', 'smartparking');

    DATABASE::query("Insert into cars (plate_number) values (\"" . $_GET['car_plate_number'] . "\")");
?>