<?php
include '../config/app.php';

if (isset($_POST['register'])) {
    if (register_guru($_POST)) {
        echo "<script>alert('Registrasi berhasil!');window.location='guru.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal!');</script>";
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
        <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../dashboard.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../dashboard_ekskul.php">Ekstrakurikuler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../dashboard_pembina.php">Pembina/guru</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Register Akun
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="siswa.php">Siswa/i</a></li>
                                <li><a class="dropdown-item" href="guru.php">Pembina/guru</a></li>
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
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Nama Pembina</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="nama">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="formGroupExampleInput" name="nip">
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="register" class="btn btn-success">Buat Akun</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container d-grid mt-3">
            <a href="../dashboard.php" class="btn btn-secondary">Kembali</a>
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