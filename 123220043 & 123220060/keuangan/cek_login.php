<?php
session_start(); // Memulai session

// Menghubungkan ke database
$connection = new mysqli('localhost', 'root', '', 'keuangan');

// Cek koneksi
if ($connection->connect_error) {
    die("Koneksi ke database gagal: " . $connection->connect_error);
}

// Ambil data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Menggunakan prepared statement untuk mencegah SQL Injection
$stmt = $connection->prepare("SELECT id_login, username, role FROM login WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

// Menghitung jumlah data yang ditemukan
$cek = $result->num_rows;

if ($cek > 0) {
    // Mengambil data
    $data = $result->fetch_assoc();
    
    // Menyimpan informasi pengguna dalam session
    $_SESSION['user_id'] = $data['id_login']; // Menyimpan id_login
    $_SESSION['username'] = $data['username'];

    // Cek peran (role) pengguna
    $role = $data['role'];
    if ($role == 'admin') {
        // Redirect ke halaman admin.php jika peran adalah admin
        header('location:admin.php');
    } else {
        // Redirect ke halaman homepage.php atau halaman pengguna biasa
        header('location:homepage.php');
    }
} else {
    // Redirect ke halaman login dengan pesan gagal
    header("location:login.php?pesan=gagal");
}

$stmt->close();
$connection->close();
?>
