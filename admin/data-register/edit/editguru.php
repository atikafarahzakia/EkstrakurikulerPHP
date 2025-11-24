<?php
include '../../config/app.php';

if (!isset($_GET['id_guru'])) {
    echo "<script>
        alert('ID Guru tidak ditemukan!');
        document.location.href='../dataguru.php';
    </script>";
    exit;
}


//mengambil id barang dari url
$id = (int)$_GET['id_guru'];

$guru = datasguru("SELECT * FROM register_guru WHERE id_guru= $id")[0];
// cek apakah tombol simpan ditekan akan bertambah
if (isset($_POST['ubah'])) {
    if (edit_regisguru($_POST) > 0) {
        echo "<script>
            alert('selamat data anda berhasil di simpan');
            document.location.href = '../dataguru.php';
            </script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Edit Data Register Pembina</title>
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
        <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../../dashboard.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../dashboard_ekskul.php">Ekstrakurikuler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../dashboard_pembina.php">Pembina/guru</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Register Akun
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="../../register/siswa.php">Siswa/i</a></li>
                                <li><a class="dropdown-item" href="../../register/guru.php">Pembina/guru</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container bg-white p-4 mt-5 rounded shadow">
            <h4 class="">Register Guru</h4>
            <hr>
            <div class="">
                <form action="" method="post">
                    <!-- membuat id hidden -->
                    <input type="hidden" name="id_guru" value="<?= $guru['id_guru']; ?>">
                    <!-- ================= -->
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Nama Pembina</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="nama" value="<?= $guru['nama_guru']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="nip" value="<?= $guru['nip']; ?>">
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="ubah" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container d-grid mt-3">
            <a href="../dataguru.php" class="btn btn-secondary">Kembali</a>
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