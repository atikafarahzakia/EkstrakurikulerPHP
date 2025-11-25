<?php
session_start();
include 'config/app.php';

// Cek apakah siswa sudah login
if (!isset($_SESSION['id_siswa'])) {
    header("Location: login_siswa.php");
    exit();
}

// Ambil data siswa dari session
$id_siswa = $_SESSION['id_siswa'];
$nama_siswa = $_SESSION['nama_siswa'];

// Ambil semua ekskul yang diikuti siswa termasuk pembina dan jadwal
$ekskul_list = tampildata_ekskul("
    SELECT 
        e.id_ekskul,
        e.nama_ekskul,
        p.nama_pembina,
        j.hari,
        j.jam
    FROM tb_siswa_ekskul se
    JOIN tb_ekskul e ON se.id_ekskul = e.id_ekskul
    LEFT JOIN tb_ekskul_pembina ep ON e.id_ekskul = ep.id_ekskul
    LEFT JOIN tb_pembina p ON ep.id_guru = p.id_guru
    LEFT JOIN tb_jadwal j ON e.id_ekskul = j.id_ekskul
    WHERE se.id_siswa = '$id_siswa'
");
?>

<!doctype html>
<html lang="en">

<head>
    <title>Dashboard Siswa</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Ekstrakurikuler SMK7</a>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
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

    <main class="container mt-5">
        <h3>Selamat datang, <?= htmlspecialchars($nama_siswa) ?>!</h3>
        <h3 class="mt-5">Ekstrakurikuler yang kamu ikuti</h3>

        <?php if (!empty($ekskul_list)): ?> <!-- Mengecek apakah siswa mengikuti ekskul -->
            <?php foreach ($ekskul_list as $ekskul):
                $id_ekskul = $ekskul['id_ekskul'];

                // Query untuk mengambil semua siswa yang mengikuti ekskul yang sama
                $siswa_list = tampildata_ekskul("
            SELECT s.nama_siswa, s.kelas, s.jurusan
            FROM tb_siswa_ekskul se
            JOIN tb_siswa s ON se.id_siswa = s.id_siswa
            WHERE se.id_ekskul = '$id_ekskul'
        ");
            ?>
                <div class="mt-3 p-4 shadow bg-white rounded">
                    <h4><?= htmlspecialchars($ekskul['nama_ekskul']) ?> <!-- Menampilkan nama ekskul -->
                        <?php if (!empty($ekskul['nama_pembina'])): ?>
                            <!-- Menampilkan nama pembina jika tersedia -->
                            <small class="text-muted">- Pembina: <?= htmlspecialchars($ekskul['nama_pembina']) ?></small>
                        <?php endif; ?>
                    </h4>

                    <?php if (!empty($ekskul['hari'])): ?>
                        <!-- Menampilkan hari dan jam latihan jika sudah diinput -->
                        <p class="text-muted mb-0">Hari: <?= htmlspecialchars($ekskul['hari']) ?> | Jam: <?= htmlspecialchars($ekskul['jam']) ?></p>
                    <?php endif; ?>

                    <table class="table table-bordered table-striped table-hover mt-2">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($siswa_list as $siswa): ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                                    <td><?= htmlspecialchars($siswa['kelas']) ?></td>
                                    <td><?= htmlspecialchars($siswa['jurusan']) ?></td>
                                </tr>
                            <?php $no++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-warning mt-4">
                Anda belum bergabung dengan ekstrakurikuler.
                <a href="join.php" class="btn btn-primary ms-2">Join Ekskul</a>
            </div>
        <?php endif; ?>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>