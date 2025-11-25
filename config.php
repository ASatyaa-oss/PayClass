<?php

$host = "sql112.infinityfree.com";     // MySQL Hostname
$user = "if0_40507318";                // MySQL Username
$password = "Abspnsgtg18";    // MySQL Password (bukan kosong)
$database = "if0_40507318_payclass_db"; // MySQL Database name

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
