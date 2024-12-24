<?php
    require_once('../database.php');

    DATABASE::connect('localhost', 'smartparking', '123456', 'smartparking');

    DATABASE::query("UPDATE slots set status_of_slot=NULL WHERE slot_number=\"" . $_GET['slot_number'] . "\"");
?>

