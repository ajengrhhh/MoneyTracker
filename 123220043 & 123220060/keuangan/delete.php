<?php
include 'koneksi.php'; // Menghubungkan ke database

// Pastikan id_detail sudah diterima melalui parameter GET
if (!isset($_GET['id_detail'])) {
    echo "Parameter id_detail tidak ditemukan.";
    exit();
}

$id_detail = $_GET['id_detail'];

// Mulai transaksi
mysqli_autocommit($konek, false); // Nonaktifkan autocommit untuk memulai transaksi

$success = true;

// Hapus data dari tabel pemasukan
$query_pemasukan = mysqli_query($konek, "DELETE FROM pemasukan WHERE id_detail='$id_detail'");
if (!$query_pemasukan) {
    $success = false;
    echo "Gagal menghapus data dari tabel pemasukan: " . mysqli_error($konek) . "<br>";
}

// Hapus data dari tabel pengeluaran
$query_pengeluaran = mysqli_query($konek, "DELETE FROM pengeluaran WHERE id_detail='$id_detail'");
if (!$query_pengeluaran) {
    $success = false;
    echo "Gagal menghapus data dari tabel pengeluaran: " . mysqli_error($konek) . "<br>";
}

// Hapus data dari tabel detail
$query_detail = mysqli_query($konek, "DELETE FROM detail WHERE id_detail='$id_detail'");
if (!$query_detail) {
    $success = false;
    echo "Gagal menghapus data dari tabel detail: " . mysqli_error($konek) . "<br>";
}

// Commit atau rollback transaksi
if ($success) {
    mysqli_commit($konek); // Commit transaksi jika berhasil
    mysqli_autocommit($konek, true); // Mengaktifkan autocommit kembali

    // Redirect ke halaman homepage.php
    header("location: homepage.php");
    exit();
} else {
    mysqli_rollback($konek); // Rollback transaksi jika ada kesalahan
    mysqli_autocommit($konek, true); // Mengaktifkan autocommit kembali

    echo "Transaksi dibatalkan karena terjadi kesalahan.";
}

// Tutup koneksi
mysqli_close($konek);
?>
