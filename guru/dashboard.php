<?php
session_start();
include 'config/app.php';


if (!isset($_SESSION['id_guru'])) {
header("Location: login/login.php");
exit();
}


$id_guru = (int)$_SESSION['id_guru'];
$nama_pembina = $_SESSION['nama_pembina'];


$query_ekskul = mysqli_query($db, "
SELECT e.id_ekskul, e.nama_ekskul, j.hari, j.jam
FROM tb_ekskul_pembina ep
JOIN tb_ekskul e ON ep.id_ekskul = e.id_ekskul
LEFT JOIN tb_jadwal j ON j.id_ekskul = e.id_ekskul
WHERE ep.id_pembina = $id_guru
");


if (!$query_ekskul) die("Query ekskul gagal: " . mysqli_error($db));


$ekskul_list = [];
while ($row = mysqli_fetch_assoc($query_ekskul)) {
$ekskul_list[] = $row;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Dashboard Pembina</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ekstrakurikuler SMK7</a>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav w-100">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ekskul.php">Ekstrakurikuler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard_pembina.php">Pembina/guru</a>
                        </li>
                        <li class="nav-item ms-auto">
                            <a href="login/logout.php" class="btn btn-danger">Logout</a>
                        </li>
                    </ul>
                </div>
        </div>
    </nav>

    <main class="container mt-5">
        <h3>Selamat datang, <?= htmlspecialchars($nama_pembina) ?>!</h3>
        <h4 class="mt-4">Ekskul yang Anda Bina</h4>

        <?php if (!empty($ekskul_list)): ?>
            <?php foreach ($ekskul_list as $ekskul):
                $id_ekskul = $ekskul['id_ekskul'];

                $query_siswa = mysqli_query($db, "
                    SELECT s.nama_siswa, s.kelas, s.jurusan
                    FROM tb_siswa_ekskul se
                    JOIN tb_siswa s ON se.id_siswa = s.id_siswa
                    WHERE se.id_ekskul = '$id_ekskul'
                ");
            ?>
                <div class="mt-3 p-4 shadow bg-white rounded">
                    <h4><?= htmlspecialchars($ekskul['nama_ekskul']) ?></h4>
                    <p class="text-muted">Hari: <?= $ekskul['hari'] ?> | Jam: <?= $ekskul['jam'] ?></p>

                    <table class="table table-bordered table-striped table-hover mt-3">
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
            <div class="alert alert-warning mt-3">Anda belum membina ekskul apapun.</div>
        <?php endif; ?>
    </main>
</body>

</html>