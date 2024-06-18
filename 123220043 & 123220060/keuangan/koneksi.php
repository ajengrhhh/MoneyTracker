<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "keuangan";
$konek= new mysqli($hostname,$username,$password,$database);
if ($konek->connect_error) {
die("Maaf koneksi error". $konek->connect_error);
}
?>