<?php
include 'koneksi.php';
$id_login= $_GET['id_login'];
$query= mysqli_query($konek,"DELETE FROM login WHERE id_login='$id_login'");
if($query) {
header("location:admin.php");
} else {
echo"Data gagal dihapus";
}
?>