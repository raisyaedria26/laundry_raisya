<?php

$host_koneksi = "localhost";
$username_koneksi = "root";
$password_koneksi = "";
$database_name = "laundry_raisya";

$config = mysqli_connect($host_koneksi, $username_koneksi, $password_koneksi, $database_name);
if (!$config) echo "Koneksi Gagal";
