<?php
session_start(); // Memulai session

// Memastikan ada yang login
if (!isset($_SESSION['username'])) {
    header("location: login.php?pesan=belum_login");
    exit();
}

include "koneksi.php"; // Menghubungkan ke database

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

// Query untuk mengambil data pengeluaran berdasarkan id_login pengguna yang sedang login
$query_detail = "SELECT * FROM detail WHERE id_login = ?";
$stmt_detail = $konek->prepare($query_detail);
$stmt_detail->bind_param("i", $id_login);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();

// Hitung total pemasukan
$query_pemasukan = "SELECT SUM(harga) AS total_pemasukan FROM detail WHERE jenis='pemasukan' AND id_login = ?";
$stmt_pemasukan = $konek->prepare($query_pemasukan);
$stmt_pemasukan->bind_param("i", $id_login);
$stmt_pemasukan->execute();
$result_pemasukan = $stmt_pemasukan->get_result();
$row_pemasukan = $result_pemasukan->fetch_assoc();
$total_pemasukan = $row_pemasukan['total_pemasukan'];

// Hitung total pengeluaran
$query_pengeluaran = "SELECT SUM(harga) AS total_pengeluaran FROM detail WHERE jenis='pengeluaran' AND id_login = ?";
$stmt_pengeluaran = $konek->prepare($query_pengeluaran);
$stmt_pengeluaran->bind_param("i", $id_login);
$stmt_pengeluaran->execute();
$result_pengeluaran = $stmt_pengeluaran->get_result();
$row_pengeluaran = $result_pengeluaran->fetch_assoc();
$total_pengeluaran = $row_pengeluaran['total_pengeluaran'];

// Hitung selisih antara total pemasukan dan total pengeluaran
$selisih = $total_pemasukan - $total_pengeluaran;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Kas UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-image: url('bg2.jpg'); /* Gambar latar belakang */
            background-size: cover; /* Menutup seluruh halaman dengan gambar */
            background-repeat: no-repeat; /* Gambar tidak diulang */
            background-position: center; /* Memusatkan gambar */
            padding-top: 50px; /* Menambah ruang di atas */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Menjadikan tinggi setidaknya setinggi layar */
        }

        .page-container {
            background-color: darkgray; /* Warna latar belakang transparan */
            border-radius: 20px; /* Membuat sudut oval */
            padding: 20px; /* Menambah padding */
            width: 80%; /* Lebar konten */
        }

        .bg-tambah-transaksi, .bg-pengeluaran, .bg-pemasukan {
            border-radius: 20px; /* Membuat sudut oval */
            padding: 20px; /* Menambah padding */
            margin: 10px 0; /* Menambah margin atas dan bawah */
            font-size: 1.5rem; /* Memperbesar teks */
            text-align: center; /* Memusatkan teks */
        }

        .bg-tambah-transaksi {
            background-color: #f8d7da; /* Warna latar belakang untuk TAMBAH TRANSAKSI */
        }

        .bg-pengeluaran {
            background-color: #d1ecf1; /* Warna latar belakang untuk PENGELUARAN */
        }

        .bg-pemasukan {
            background-color: #d4edda; /* Warna latar belakang untuk PEMASUKAN */
        }

        .clickable {
            text-decoration: none; /* Menghilangkan garis bawah pada tautan */
            color: inherit; /* Membuat warna teks mengikuti warna kolom */
            display: block; /* Membuat elemen a menjadi block level */
        }

        .bg-hasil {
            border-radius: 20px; /* Membuat sudut oval */
            padding: 20px; /* Menambah padding */
            margin: 10px; /* Menambah margin */
            font-size: 1.5rem; /* Memperbesar teks */
            text-align: center; /* Memusatkan teks */
            background-color: #d1ecf1; /* Warna latar belakang */
        }

        .bg-logout {
            background-color: #ffc107; /* Warna latar belakang */
            padding: 10px; /* Menambah padding */
            border-radius: 10px; /* Membuat sudut oval */
            text-align: center; /* Memusatkan teks */
            margin-top: 20px; /* Menambah margin atas */
        }

        .total {
            font-weight: bold; /* Membuat teks tebal */
            font-size: 1.2rem; /* Ukuran teks */
            color: #fff; /* Warna teks */
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h1>BUKU KAS UMKM</h1>
                    <img src="animasi.jpg" alt="foto" width="300" height="200">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 bg-tambah-transaksi">
                    TAMBAH TRANSAKSI
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5 bg-pengeluaran">
                    <a href="pengeluaran.php" class="clickable">PENGELUARAN</a>
                </div>
                <div class="col-md-5 bg-pemasukan">
                    <a href="pemasukan.php" class="clickable">PEMASUKAN</a>
                </div>
            </div>
            <div class="row mt-4 bg-secondary">
                <div class="col">Nama</div>
                <div class="col">Jenis</div>
                <div class="col">Tanggal</div>
                <div class="col">harga</div>
                <div class="col">Aksi</div>
            </div>
            <?php
            if ($result_detail->num_rows > 0) {
                while ($row = $result_detail->fetch_assoc()) {
                    echo "<div class='row bg-light'>";
                    echo "<div class='col'>" . $row["nama"] . "</div>";
                    echo "<div class='col'>" . $row["jenis"] . "</div>";
                    echo "<div class='col'>" . $row["tanggal"] . "</div>";
                    echo "<div class='col'>" . $row["harga"] . "</div>";
                    echo "<div class='col'>
                        <form action='delete.php' method='GET'>
                            <input type='hidden' name='id_detail' value='" . $row["id_detail"] . "'>
                            <button type='submit' class='btn btn-danger'>Delete</button>
                        </form>
                    </div>"; 
                    echo "</div>";
                }
            } else {
                echo "<div class='row'><div class='col'>0 results</div></div>";
            }
            ?>
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <?php
                    // Tampilkan hasil
                    echo "<p class='total'>PEMASUKAN: " . $total_pemasukan . "</p>";
                    echo "<p class='total'>PENGELUARAN: " . $total_pengeluaran . "</p>";
                    echo "<p class='total'>BIAYA KESELURUHAN: " . $selisih . "</p>";
                    
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 bg-logout">
                    <a href="logout.php" class="clickable">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
