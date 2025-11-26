<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login/login_admin.php");
    exit();
}

include 'config/app.php';

$jumlah_ekskul = count(tampildata_ekskul("SELECT * FROM tb_ekskul"));
$jumlah_guru   = count(tampildataguru("SELECT * FROM tb_pembina"));
$jumlah_siswa  = count(tampildatasiswa("SELECT * FROM tb_siswa"));
?>

<!doctype html>
<html lang="en">

<head>
    <title>Dashboard Admin</title>
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
                <a class="navbar-brand" href="#">Ekstrakurikuler SMK7</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav w-100">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard_ekskul.php">Ekstrakurikuler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard_pembina.php">Pembina/guru</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Register Akun
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="register/siswa.php">Siswa/i</a></li>
                                <li><a class="dropdown-item" href="register/guru.php">Pembina/guru</a></li>
                            </ul>
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
        <div class="container mt-5">
            <h3>Selamat Datang</h3>
            <h5>Kelola Ekstrakurikuler</h5>
            <hr>

            <div class="mt-5">
                <h3>Jumlah Data</h3>
                <div class="row text-center mt-3">
                    <div class="col-md-3">
                        <div class="card shadow p-3 border-primary">
                            <h5>Total Ekskul</h5>
                            <h2><?= $jumlah_ekskul; ?></h2>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow p-3 border-success">
                            <h5>Total Pembina</h5>
                            <h2><?= $jumlah_guru; ?></h2>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow p-3 border-warning">
                            <h5>Total Siswa</h5>
                            <h2><?= $jumlah_siswa; ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h3>Tambah Data</h3>
                <div class="d-flex mt-3 justify-content-between bg-white p-4 rounded shadow">
                    <div class="">
                        <a href="ekskul/formekskul.php" class="btn btn-primary"><img src="img/open-book.png" alt="" width="100px"></a>
                        <h5 class="text-center mt-2">Ekstrakurikuler</h5>
                    </div>
                    <div class="">
                        <a href="guru/formguru.php" class="btn btn-success"><img src="img/teacher.png" alt="" width="100px"></a>
                        <h5 class="text-center mt-2">Pembina</h5>
                    </div>
                    <div class="">
                        <a href="register/siswa.php" class="btn btn-warning"><img src="img/registrationsiswa.png" alt="" width="100px"></a>
                        <h5 class="text-center mt-2">Register Siswa</h5>
                    </div>
                    <div class="">
                        <a href="register/guru.php" class="btn btn-info"><img src="img/registrationguru.png" alt="" width="100px"></a>
                        <h5 class="text-center mt-2">Register Pembina</h5>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h3>Data Register Siswa - Pembina</h3>
                <div class="d-flex mt-3 bg-white p-4 rounded shadow gap-5 justify-content-center">
                    <div class="col-md-3">
                        <div class="card shadow p-3 border-primary">
                            <a href="data-register/datasiswa.php"><img src="img/study.png" alt="" width="150px"></a>
                            <h5 class="text-center mt-2">Data Siswa</h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow p-3 border-primary">
                            <a href="data-register/dataguru.php"><img src="img/training.png" alt="" width="150px"></a>
                            <h5 class="text-center mt-2">Data Guru</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p class="mb-0">© 2025 Atika Farah Zakia XI PPLG 2</p>
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