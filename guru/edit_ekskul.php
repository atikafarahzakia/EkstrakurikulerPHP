<?php
include 'config/app.php';

if (!isset($_GET['id_ekskul'])) {
    die("ERROR: id_ekskul tidak ditemukan di URL");
}

$id = (int)$_GET['id_ekskul'];

// AMBIL DATA EKSUL + JADWAL
$ekskul = tampildata("
    SELECT 
        tb_ekskul.id_ekskul,
        tb_ekskul.nama_ekskul AS ekskul,
        tb_jadwal.hari,
        tb_jadwal.jam
    FROM tb_ekskul
    LEFT JOIN tb_jadwal ON tb_jadwal.id_ekskul = tb_ekskul.id_ekskul
    WHERE tb_ekskul.id_ekskul = $id
")[0];

// cek apakah tombol simpan ditekan
if (isset($_POST['ubah'])) {
    if (editekskul($_POST) > 0) {
        echo "<script>
            alert('selamat data anda berhasil di simpan');
            document.location.href = 'ekskul.php';
            </script>";
    } else {
        echo "<script>
            alert('data anda gagal di simpan');
            document.location.href = 'ekskul.php';
            </script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body>
    <header>
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
    </header>
    <main>
        <div class="">
            <div class="container bg-white p-4 mt-5 rounded shadow">
                <h2 class="text-center text-primary">Update Ekstrakurikuler</h2>
                <form action="" method="POST">
                    <!-- membuat id hidden -->
                    <input type="hidden" name="id_ekskul" value="<?= $ekskul['id_ekskul']; ?>">
                    <!-- ================= -->
                    <div class="mb-3">
                        <label class="form-label">Nama Ekstrakurikuler</label>
                        <input type="text" name="ekskul" class="form-control" required value="<?= $ekskul['ekskul']; ?>">
                    </div>

                    <label class="form-label">Hari Pelatihan</label>
                    <?php
                    $hari_list = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                    ?>
                    <select name="hari" class="form-select mb-3" required>
                        <option value="">Pilih Hari</option>
                        <?php foreach ($hari_list as $h): ?>
                            <option value="<?= $h ?>" <?= ($ekskul['hari'] == $h) ? 'selected' : '' ?>><?= $h ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="mb-3">
                        <label class="form-label">Jam Pelatihan</label>
                        <input type="time" name="jam" class="form-control" required value="<?= $ekskul['jam']; ?>">
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="ubah" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <div class="container d-grid">
                <a href="ekskul.php" class="btn btn-secondary mt-3">Kembali</a>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>