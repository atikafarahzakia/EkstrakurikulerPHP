<?php
session_start();
include '../config/connect.php';

// Cek apakah tombol login ditekan
if (isset($_POST['login'])) {

    // Ambil input dari form 
    $nama_pembina = trim($_POST['nama_pembina']);
    $nip = trim($_POST['nip']);

    // Ambil data guru berdasarkan nama guru/pembina
    $query = mysqli_query($db, "
        SELECT * FROM register_guru 
        WHERE nama_guru = '$nama_pembina'
        LIMIT 1
    ");

    // Jika query gagal, tampilkan error MySQL
    if (!$query) {
        die("Query guru gagal: " . mysqli_error($db));
    }

    // Ambil hasil query dalam bentuk array
    $data = mysqli_fetch_assoc($query);

    // Jika data guru ditemukan berdasarkan nama
    if ($data) {

        // Cek apakah NIP yang dimasukkan sesuai dengan database
        if ($nip == $data['nip']) {

            // ✔ Set session untuk guru yang login
            $_SESSION['id_guru'] = $data['id_guru'];
            $_SESSION['nama_pembina'] = $data['nama_guru'];

            // Ambil semua ekskul yang dibina guru tersebut
            $qEkskul = mysqli_query($db, "
                SELECT e.nama_ekskul
                FROM tb_ekskul_pembina ep
                JOIN tb_ekskul e ON e.id_ekskul = ep.id_ekskul
                WHERE ep.id_guru = {$data['id_guru']}
            ");

            // Jika query ekskul error
            if (!$qEkskul) {
                die('Query ekskul gagal: ' . mysqli_error($db));
            }

            // Simpan nama ekskul ke dalam array
            $listEks = [];
            while ($r = mysqli_fetch_assoc($qEkskul)) {
                $listEks[] = $r['nama_ekskul'];
            }

            // Simpan daftar ekskul ke session
            $_SESSION['ekskul_pembina'] = $listEks;
            echo "<script>alert('Login Berhasil!'); window.location='../dashboard.php';</script>";
            exit();

        } else {
            echo "<script>alert('NIP salah!'); window.location='login.php';</script>";
            exit();
        }

    } else {
        echo "<script>alert('Nama Guru/Pembina tidak ditemukan!'); window.location='login.php';</script>";
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
                <form action="" method="post" autocomplete="off">
                    <div class="mb-3">
                        <label>Nama Pembina</label>
                        <input type="text" class="form-control" placeholder="Masukan nama siswa" name="nama_pembina" required>
                    </div>
                    <div class="mb-3">
                        <label>NIP</label>
                        <input type="password" class="form-control" placeholder="Masukan NIP" name="nip" required>
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