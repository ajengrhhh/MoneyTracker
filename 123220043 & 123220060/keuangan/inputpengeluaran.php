<?php
session_start(); // Memulai session

include "koneksi.php"; // Menghubungkan ke database

// Pastikan ada yang login
if (!isset($_SESSION['username'])) {
    header("location: login.php?pesan=belum_login");
    exit();
}

// Ambil id_login dari session yang sedang aktif
$username = $_SESSION['username'];
$stmt_user = $konek->prepare("SELECT id_login FROM login WHERE username = ?");
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $id_login = $row_user['id_login'];
} else {
    echo "Gagal mendapatkan id_login dari pengguna yang sedang login.";
    exit();
}

// Ambil data dari form
$nama = $_POST['nama'];
$jenis = $_POST['jenis'];
$tanggal = $_POST['tanggal'];
$jumlah = $_POST['jumlah'];

// Validasi input
if (empty($nama) || empty($jenis) || empty($tanggal) || empty($jumlah)) {
    echo "Nama, jenis, tanggal, dan jumlah harus diisi!";
    exit();
}

// Ubah format tanggal ke 'YYYY-MM-DD'
$tanggal_mysql = date('Y-m-d', strtotime($tanggal));

// Mulai transaksi
$konek->begin_transaction();

try {
    // Insert data ke tabel detail
    $stmt_detail = $konek->prepare("INSERT INTO detail (nama, jenis, tanggal, harga, id_login) VALUES (?, ?, ?, ?, ?)");
    $stmt_detail->bind_param("ssssi", $nama, $jenis, $tanggal_mysql, $jumlah, $id_login);
    $stmt_detail->execute();

    // Ambil id_detail terakhir yang di-generate oleh auto-increment
    $id_detail = $stmt_detail->insert_id;

    // Insert data ke tabel pemasukan
    $stmt_pemasukan = $konek->prepare("INSERT INTO pengeluaran (nama, jenis, tanggal, harga, id_login, id_detail) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_pemasukan->bind_param("ssssii", $nama, $jenis, $tanggal_mysql, $jumlah, $id_login, $id_detail);
    $stmt_pemasukan->execute();

    // Commit transaksi jika semua query berhasil
    $konek->commit();

    // Redirect ke halaman pemasukan dengan pesan sukses
    header("location:pengeluaran.php?pesan=input_sukses");
    exit();

} catch (Exception $e) {
    // Rollback transaksi jika terjadi kesalahan
    $konek->rollback();

    // Tampilkan pesan error
    echo "Gagal melakukan transaksi: " . $e->getMessage();
}

$stmt_detail->close();
$stmt_pemasukan->close();
$stmt_user->close();
$konek->close();
?>
