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

// Query untuk mengambil semua data dari tabel login
$query_login = "SELECT * FROM login";
$stmt_login = $konek->prepare($query_login);
$stmt_login->execute();
$result_login = $stmt_login->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PAGE | Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-image: url('bg2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding-top: 50px;
            margin: 0;
        }

        .page-container {
            background-color: darkgray;
            border-radius: 20px;
            padding: 20px;
            margin: 20px auto; /* Tengahkan konten dengan margin atas dan bawah otomatis */
            max-width: 800px; /* Atur lebar maksimum untuk konten */
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
    </style>
</head>
<body>
    <div class="container page-container">
        <div class="row">
            <div class="col text-center">
                <h1>PAGE ADMIN</h1>
                <img src="animasi.jpg" alt="foto" width="300" height="200">
            </div>
        </div>
        <div class="container text-center">
            <div class="row bg-secondary">
                <div class="col">ID Login</div>
                <div class="col">Username</div>
                <div class="col">Password</div>
                <div class="col">Role</div>
                <div class="col">Aksi</div>
            </div>
            <?php
            // Mengecek apakah query mengembalikan hasil
            if ($result_login->num_rows > 0) {
                // Output data dari setiap baris
                while($row = $result_login->fetch_assoc()) {
                    echo "<div class='row bg-light'>"; // Menambahkan warna latar belakang
                    echo "<div class='col'>" . htmlspecialchars($row["id_login"]) . "</div>";
                    echo "<div class='col'>" . htmlspecialchars($row["username"]) . "</div>";
                    echo "<div class='col'>" . htmlspecialchars($row["password"]) . "</div>";
                    echo "<div class='col'>" . htmlspecialchars($row["role"]) . "</div>";
                    echo "<div class='col'>
                    <form action='deleteuser.php' method='GET'>
                    <input type='hidden' name='id_login' value='" . $row["id_login"] . "'>
                    <button type='submit' class='btn btn-danger'>Delete</button>
                </form>
            </div>"; 
                    echo "</div>";
                }
            } else {
                echo "<div class='row'><div class='col'>Tidak ada data.</div></div>"; // Tambahkan pesan jika tidak ada data
            }
            ?>
            <div class="row">
                <div class="col-md-12 bg-logout">
                    <a href="logout.php" class="clickable">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$stmt_user->close();
$stmt_login->close();
$konek->close();
?>
