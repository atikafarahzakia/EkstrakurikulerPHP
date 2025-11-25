<?php
session_start();
include '../admin/config/connect.php';

// prosses ketika tombol login di tekan
if (isset($_POST['login'])) {

    $nama_siswa = trim($_POST['nama_siswa']); // hilangkan spasi
    $nisn = trim($_POST['nisn']);

    // fungsinya untuk mencari data  siswa berdasarkan apa yang di input oleh user
    //menggunakan limit 1 agar mengambil 1 data aja
    $query = mysqli_query($db, "SELECT * FROM register_siswa WHERE nama_siswa = '$nama_siswa' LIMIT 1");
    if (!$query) {
        die("Query gagal: " . mysqli_error($db));
    }

    // mengambil data dari query yg di atas
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // ngecek jika nisn sama dengan data yang ada di database
        if ($nisn == $data['nisn']) {
            // Jika cocok, set session untuk menyimpan data siswa yang login
            $_SESSION['id_siswa'] = $data['id_siswa'];
            $_SESSION['nama_siswa'] = $data['nama_siswa'];
            $_SESSION['kelas'] = $data['kelas'];
            $_SESSION['jurusan'] = $data['jurusan'];

            echo "<script>alert('Login Berhasil!'); window.location='dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('NISN salah!'); window.location='login_siswa.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Nama siswa tidak ditemukan!'); window.location='login_siswa.php';</script>";
        exit();
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Login Siswa</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
                <h3 class="text-center mb-3">Login Sebagai Siswa</h3>
                <form action="" method="post">
                    <div class="mb-3">
                        <label>Nama Siswa</label>
                        <input type="text" class="form-control" placeholder="Masukan nama siswa" name="nama_siswa" required>
                    </div>
                    <div class="mb-3">
                        <label>NISN</label>
                        <input type="password" class="form-control" placeholder="Masukan NISN" name="nisn" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="d-grid mt-3">
                    <a href="../awal.php" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>