<?php
$connect = new mysqli("localhost", "root", "1234567890", "clearance_system");

if ($connect->connect_error) {
    exit('Error while connecting to Database: <b>' . $connect->connect_error . '</b>');
}
