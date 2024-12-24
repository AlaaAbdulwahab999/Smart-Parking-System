<?php
    require_once('../database.php');

    DATABASE::connect('localhost', 'smartparking', '123456', 'smartparking');
    
    $car_state = DATABASE::query("SELECT payment_time from cars WHERE plate_number=\"${_GET['car_plate_number']}\"");

    if($car_state[0]['payment_time'] === NULL) {
        echo "PLEASE pay your parking fees first";
    } else { 
        DATABASE::query(
            "UPDATE cars set departure_time  = current_timestamp() WHERE plate_number = \""
            . $_GET['car_plate_number']
            . "\""
        );
    }
?>