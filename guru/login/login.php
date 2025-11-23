<?php
session_start();
include '../config/connect.php';

if (isset($_POST['login'])) {

    $nama_pembina = trim($_POST['nama_pembina']);
    $nip = trim($_POST['nip']);

    $query = mysqli_query($db, "SELECT * FROM register_guru WHERE nama_guru = '$nama_pembina' LIMIT 1");

    if (!$query) {
        die("Query gagal: " . mysqli_error($db));
    }

    $data = mysqli_fetch_assoc($query);

    if ($data) {
        if ($nip == $data['nip']) {

            $_SESSION['id_guru'] = $data['id_guru']; // session utama
            $_SESSION['nama_pembina'] = $data['nama_guru'];
            $_SESSION['ekskul_pembina'] = $data['ekskul'];

            echo "<script>alert('Login Berhasil!'); window.location='../dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('NIP salah!'); window.location='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Nama Guru/pembina tidak ditemukan!'); window.location='login.php';</script>";
        exit();
    }
}
?>



<!doctype html>
<html lang="en">

<head>
    <title>Login Guru/pembina</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
                <h3 class="text-center mb-3">Login Sebagai Guru/pembina</h3>
                <form action="" method="post">
                    <div class="mb-3">
                        <label>Nama Pembina</label>
                        <input type="text" class="form-control" placeholder="Masukan nama siswa" name="nama_pembina" required>
                    </div>
                    <div class="mb-3">
                        <label>NIP</label>
                        <input type="password" class="form-control" placeholder="Masukan NISN" name="nip" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="d-grid mt-3">
                    <a href="../../awal.php" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>