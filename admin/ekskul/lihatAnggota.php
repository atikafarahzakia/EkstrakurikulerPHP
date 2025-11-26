<?php
include '../config/connect.php';

if (!isset($_GET['id_ekskul'])) {
    echo "<script>alert('ID ekskul tidak ditemukan!'); window.location='../dashboard.php';</script>";
    exit();
}

// Ambil id ekskul dari URL
$id_ekskul = $_GET['id_ekskul'];

// Ambil nama ekskul
$ekskul = mysqli_query($db, "SELECT nama_ekskul FROM tb_ekskul WHERE id_ekskul = '$id_ekskul'");
$data_ekskul = mysqli_fetch_assoc($ekskul);

// Ambil daftar anggota
$query_anggota = mysqli_query($db, "
    SELECT r.nama_siswa, r.kelas, r.jurusan
    FROM tb_siswa_ekskul se 
    JOIN register_siswa r ON r.id_siswa = se.id_siswa
    WHERE se.id_ekskul = '$id_ekskul'
");


if (!$query_anggota) {
    die("Query Error: " . mysqli_error($db));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota Ekskul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5 p-4 shadow bg-white rounded">
        <h2 class="text-center">Anggota Ekstrakurikuler</h2>
        <h4 class="text-center text-primary">"<?= $data_ekskul['nama_ekskul']; ?>"</h4>
        <hr>

        <a href="../dashboard_ekskul.php" class="btn btn-secondary mb-3">Kembali</a>
        <!-- <form class="d-flex mt-2">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form> -->
        <table class="table table-bordered table-striped table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($query_anggota) > 0) {
                    while ($anggota = mysqli_fetch_assoc($query_anggota)) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $anggota['nama_siswa']; ?></td>
                            <td><?= $anggota['kelas']; ?></td>
                            <td><?= $anggota['jurusan']; ?></td>
                        </tr>
                    <?php
                    }
                } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada anggota yang terdaftar</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>