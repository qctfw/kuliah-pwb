<?php
$host = 'localhost';
$db_name = 'azhar_lks_uas';
$username = 'root';
$password = '';

$connection = mysqli_connect($host, $username, $password, $db_name);

$number_formatter = new NumberFormatter('id_ID', NumberFormatter::DECIMAL);
$currency_formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
?>