<?php
include "koneksi.php"; // Menghubungkan ke database

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Validasi input
if (empty($username) || empty($password)) {
    header("location:form_signup.php?pesan=gagal");
    exit();
}

// Menggunakan prepared statement untuk mencegah SQL Injection
$stmt = $konek->prepare("INSERT INTO login (username, password, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $password, $role);
$result = $stmt->execute();

if ($result) {
    // Proses input berhasil, arahkan ke halaman login
    header("location:login.php?pesan=signup_sukses");
} else {
    // Tampilkan pesan error
    echo "Gagal: " . $stmt->error;
}

$stmt->close();
$konek->close();
?>
