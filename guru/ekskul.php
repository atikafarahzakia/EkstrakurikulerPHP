<?php
session_start();
include 'config/app.php';

if (!isset($_SESSION['id_guru'])) {
    header("Location: login/login.php");
    exit();
}

$id_guru = $_SESSION['id_guru'];
$nama_pembina = $_SESSION['nama_pembina'];

// ambil data ekskul yang dibina guru
$query_ekskul = mysqli_query($db, "
    SELECT e.id_ekskul, e.nama_ekskul, j.hari, j.jam
    FROM tb_ekskul_pembina ep
    JOIN tb_ekskul e ON ep.id_ekskul = e.id_ekskul
    LEFT JOIN tb_jadwal j ON j.id_ekskul = e.id_ekskul
    WHERE ep.id_guru = '$id_guru'
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
                    <li class="nav-item ms-auto">
                        <a href="login/logout.php" class="btn btn-danger">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="mt-3 p-4 shadow bg-white rounded">
            <table class="table table-bordered table-striped table-hover mt-3 text-center">
                <h3 class="text-center">Daftar Ekstrakurikuler anda bina</h3>
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Ekskul</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($ekskul_list as $row):
                    ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= htmlspecialchars($row['nama_ekskul']) ?></td>
                            <td><?= $row['hari'] ? $row['hari'] : '-' ?></td>
                            <td><?= $row['jam'] ? $row['jam'] : '-' ?></td>
                            <td>
                               <a href="edit_ekskul.php?id_ekskul=<?= $row['id_ekskul']; ?>" class="btn btn-warning btn-sm">Edit</a>

                            </td>
                        </tr>
                    <?php $no++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>