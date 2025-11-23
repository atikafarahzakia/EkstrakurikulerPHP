<?php
session_start();
include 'config/app.php';
if (!isset($_SESSION['id_siswa'])) {
    header("Location: login_siswa.php");
    exit();
}

$id_siswa = $_SESSION['id_siswa'];
$nama_siswa = $_SESSION['nama_siswa'];

// Ambil semua ekskul yang diikuti siswa beserta pembina dan hari
$query_ekskul = mysqli_query($db, "
    SELECT e.id_ekskul, e.nama_ekskul, j.hari, p.nama_pembina
    FROM tb_siswa_ekskul se
    JOIN tb_ekskul e ON se.id_ekskul = e.id_ekskul
    LEFT JOIN tb_pembina p ON p.id_ekskul = e.id_ekskul
    LEFT JOIN tb_jadwal j ON j.id_ekskul = e.id_ekskul
    WHERE se.id_siswa = '$id_siswa'
");



if (!$query_ekskul) die("Query gagal: " . mysqli_error($db));

$ekskul_list = [];
while ($row = mysqli_fetch_assoc($query_ekskul)) {
    $ekskul_list[] = $row;
}
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

        <?php if (!empty($ekskul_list)): ?>
            <?php foreach ($ekskul_list as $ekskul):
                $id_ekskul = $ekskul['id_ekskul'];

                // Ambil semua siswa yang ikut ekskul ini termasuk kelas & jurusan
                $query_siswa = mysqli_query($db, "
            SELECT s.nama_siswa, s.kelas, s.jurusan
            FROM tb_siswa_ekskul se
            JOIN tb_siswa s ON se.id_siswa = s.id_siswa
            WHERE se.id_ekskul = '$id_ekskul'
        ");

                if (!$query_siswa) die("Query siswa gagal: " . mysqli_error($db));
            ?>
                <div class="mt-3 p-4 shadow bg-white rounded">
                    <h4><?= htmlspecialchars($ekskul['nama_ekskul']) ?>
                        <?php if (!empty($ekskul['nama_pembina'])): ?>
                            <small class="text-muted">- Pembina: <?= htmlspecialchars($ekskul['nama_pembina']) ?></small>
                        <?php endif; ?>
                    </h4>
                    <?php if (!empty($ekskul['hari'])): ?>
                        <p class="text-muted mb-0">Hari: <?= htmlspecialchars($ekskul['hari']) ?></p>
                    <?php endif; ?>

                    </h4>
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
                            while ($siswa = mysqli_fetch_assoc($query_siswa)): ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                                    <td><?= htmlspecialchars($siswa['kelas']) ?></td>
                                    <td><?= htmlspecialchars($siswa['jurusan']) ?></td>
                                </tr>
                            <?php $no++;
                            endwhile; ?>
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