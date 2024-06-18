<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #ffffff92; /* Warna abu-abu putih */
            background-image: url('bg.jpg'); /* Gambar latar belakang */
            background-size: cover; /* Menutup seluruh halaman dengan gambar */
            background-repeat: no-repeat; /* Gambar tidak diulang */
            background-position: center; /* Memusatkan gambar */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        td {
            padding: 10px;
        }

        .login-container {
            background-color: darkgrey; /* Warna latar belakang kotak */
            padding: 20px; /* Ruang di dalam kotak */
            border-radius: 10pt; /* Membuat sudut kotak sedikit melengkung */
            border: 1px solid #dc3545; /* Border warna merah */
            text-align: center; /* Memusatkan teks di dalam kotak */
            width: 50%;
            max-width: 500px; /* Maksimal lebar kotak login */
        }

        .login-container img {
            border-radius: 15%; /* Membuat pinggiran foto agak oval */
            display: block; /* Agar gambar mengikuti margin auto dari container */
            margin: 0 auto 20px auto; /* Memusatkan gambar di dalam kotak dan menambahkan margin bawah */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card-body">
            <h1 class="text-warning">LOGIN</h1>
            <img src="animasi.jpg" alt="foto" width="250px"><br>
            <?php
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == "gagal") {
                    echo '<div class="alert alert-danger">Login Gagal! Username atau Password salah!</div>';
                } else if ($_GET['pesan'] == "logout") {
                    echo '<div class="alert alert-success">Anda berhasil Logout!</div>';
                } else if ($_GET['pesan'] == "belum_login") {
                    echo '<div class="alert alert-warning">Anda Harus login terlebih dahulu!</div>';
                }
            }
            ?>
            <form action="cek_login.php" method="POST">
                <table class="m-auto">
                    <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td><input type="text" name="username" placeholder="Masukkan Username" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td><input type="password" name="password" placeholder="Masukkan Password" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><input type="submit" value="Login" class="btn btn-warning mt-3"></td>
                    </tr>
                </table>
            </form>
            <div class="text-white mt-3">
                <p>Belum punya akun? <a href="signup.php" class="text-white">Daftar di sini.</a></p>
            </div>
        </div>
    </div>
</body>
</html>
