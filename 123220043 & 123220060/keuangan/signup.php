<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #ffffff92; /* Warna abu-abu putih */
            background-image: url('bg2.jpg'); /* Gambar latar belakang */
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

        .signup-container {
            background-color: darkgrey; /* Warna latar belakang kotak */
            padding: 20px; /* Ruang di dalam kotak */
            border-radius: 10pt; /* Membuat sudut kotak sedikit melengkung */
            border: 1px solid #ffc107; /* Border warna kuning */
            text-align: center; /* Memusatkan teks di dalam kotak */
            width: 50%;
            max-width: 500px; /* Maksimal lebar kotak signup */
            color: white; /* Warna teks putih */
        }

        .signup-container img {
            border-radius: 15%; /* Membuat pinggiran foto agak oval */
            display: block; /* Agar gambar mengikuti margin auto dari container */
            margin: 0 auto 20px auto; /* Memusatkan gambar di dalam kotak dan menambahkan margin bawah */
        }

        .btn-warning {
            margin-top: 10px;
        }

        .text-warning {
            color: #ffc107 !important; /* Warna teks kuning */
        }

        .text-warning a {
            color: #ffc107 !important; /* Warna teks kuning pada link */
        }
    </style>
</head>
<body>
    <div class="signup-container position-absolute top-50 start-50 translate-middle">
        <div class="card-body">
            <h1 class="text-warning">ISI DATA ANDA</h1>
            <img src="animasi.jpg" alt="logo" width="300px">
            <form action="inputsignin.php" method="POST">
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
                    <input type="hidden" name="role" value="user">
                    <tr>
                        <td colspan="3" class="text-center"><input type="submit" value="Simpan" class="btn btn-warning"></td>
                    </tr>
                </table>
            </form>
            <div class="mt-3">
                <a href="login.php" class="text-warning">Kembali</a>
            </div>
        </div>
    </div>
    <!-- HTML sebelumnya tetap sama -->

<?php
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == "signup_sukses") {
        echo '<div class="alert alert-success">Pendaftaran berhasil! Silahkan login.</div>';
    } else if ($_GET['pesan'] == "gagal") {
        echo '<div class="alert alert-danger">Pendaftaran gagal! Silahkan coba lagi.</div>';
    }
}
?>

</body>
</html>
