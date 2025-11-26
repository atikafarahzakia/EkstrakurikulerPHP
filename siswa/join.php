<?php
session_start(); // Memulai session agar data login bisa digunakan

include 'C:\xampp\htdocs\ekskul2025\admin\config\connect.php';

// Cek apakah siswa sudah login, jika belum arahkan ke halaman login
if (!isset($_SESSION['id_siswa'])) {
    echo "<script>alert('Silakan login dulu'); window.location='login_siswa.php';</script>";
    exit();
}

// Mengambil data siswa dari session
$nama_siswa = $_SESSION['nama_siswa'];
$kelas = $_SESSION['kelas'];
$jurusan = $_SESSION['jurusan'];

$msg = ''; // Variabel untuk menampilkan pesan status error / sukses

// Proses ketika tombol daftar dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['daftar'])) {
    $id_siswa = $_SESSION['id_siswa'];
    $gender = $_POST['gender'] ?? ''; 
    $nowa = $_POST['nowa'] ?? '';     
    $ekskul_id = $_POST['ekskul'] ?? ''; 
    $tanggal = $_POST['tanggal'] ?? '';  

    // Validasi apakah ada input yang kosong
    if (!$gender || !$nowa || !$ekskul_id || !$tanggal) {
        $msg = "Semua field wajib diisi!";
    } else {
        mysqli_begin_transaction($db); // Memulai transaksi database

        try {
            // Cek apakah siswa sudah ada di tabel tb_siswa
            $cek_siswa = mysqli_query($db, "SELECT id_siswa FROM tb_siswa WHERE id_siswa='$id_siswa'");

            // Jika belum ada, insert siswa ke tabel tb_siswa
            if (mysqli_num_rows($cek_siswa) == 0) {
                $sql_siswa = "INSERT INTO tb_siswa (nama_siswa, kelas, jurusan, jenis_kelamin, no_wa, tanggal_join)
                              VALUES ('$nama_siswa','$kelas','$jurusan','$gender','$nowa','$tanggal')";

                // Jika insert gagal, munculkan error
                if (!mysqli_query($db, $sql_siswa)) {
                    throw new Exception("Gagal insert siswa: " . mysqli_error($db));
                }

                // Ambil id siswa terakhir yang disimpan
                $id_siswa = mysqli_insert_id($db);
            }

            // Cek apakah siswa sudah mendaftar ekskul yang sama sebelumnya
            $cek_relasi = mysqli_query($db, "SELECT * FROM tb_siswa_ekskul WHERE id_siswa='$id_siswa' AND id_ekskul='$ekskul_id'");
            if (mysqli_num_rows($cek_relasi) > 0) {
                throw new Exception("Anda sudah mendaftar ekskul ini!");
            }

            // Insert ke tabel relasi tb_siswa_ekskul
            $sql_ekskul = "INSERT INTO tb_siswa_ekskul (id_siswa, id_ekskul, tanggal_join)
                            VALUES ('$id_siswa','$ekskul_id','$tanggal')";
            if (!mysqli_query($db, $sql_ekskul)) {
                throw new Exception("Gagal daftar ekskul: " . mysqli_error($db));
            }

            mysqli_commit($db); // Simpan hasil transaksi jika semua proses berhasil
            $msg = "Berhasil daftar ekskul!";
        } catch (Exception $e) {
            mysqli_rollback($db); // Batalkan transaksi jika ada error
            $msg = "Gagal: " . $e->getMessage();
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Pendaftaran Ekstrakurikuler</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ekstrakurikuler SMK7</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav w-100">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="daftar_ekskul.php">Daftar Ekstrakurikuler</a></li>
                    <li class="nav-item"><a class="nav-link" href="join.php">Join Ekstrakurikuler</a></li>
                    <li class="nav-item ms-auto"><a href="logout.php" class="btn btn-danger">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body>
    <div class="container mt-5">

        <!-- menampilkan pesan status -->
        <?php if ($msg): ?>
            <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <div class=" container card p-3 shadow">
            <h2 class="text-primary p-2">Form Pendaftaran Ekstrakurikuler</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($nama_siswa) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($kelas) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jurusan</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($jurusan) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="laki laki" required>
                        <label class="form-check-label">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="perempuan">
                        <label class="form-check-label">Perempuan</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">No WA aktif</label>
                    <input type="number" class="form-control" name="nowa" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ekstrakurikuler diminati</label>
                    <select class="form-select" name="ekskul" required>
                        <option value="">- Pilih Ekskul -</option>
                        <?php
                        $query = mysqli_query($db, "SELECT id_ekskul, nama_ekskul FROM tb_ekskul");
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<option value='{$row['id_ekskul']}'>" . htmlspecialchars($row['nama_ekskul']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pendaftaran</label>
                    <input type="date" class="form-control" name="tanggal" required>
                </div>

                <div class="d-grid">
                    <button type="submit" name="daftar" class="btn btn-success">Daftar</button>
                </div>
            </form>
        </div>

        <div class="d-grid">
            <a href="dashboard.php" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</body>
</html>