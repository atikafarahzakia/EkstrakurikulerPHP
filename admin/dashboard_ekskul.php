<?php
include 'config/app.php';

?>

<!doctype html>
<html lang="en">

<head>
    <title>Ekstrakurikuler</title>
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
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container bg-white p-4 mt-5 rounded shadow">
            <h2 class="text-center">EKSTRAKURIKULER</h2>
            <hr>
            <div class="d-grid gap-2 mt-3">
                <a href="ekskul/formekskul.php" class="btn btn-success">Tambah Ekstrakurikuler</a>
            </div>
            <h2 class="mt-5">Daftar Ekstrakurikuler</h2>
            <form class="d-flex mt-2" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="cari">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <table class="table table-striped table-hover table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Ekstrakurikuler</th>
                        <th scope="col">Hari Pelatihan</th>
                        <th scope="col">Jam Pelatihan</th>
                        <th scope="col">Lihat Anggota</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data_ekskul as $data): ?>

                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['nama_ekskul']; ?></td>
                            <td><?= $data['hari']; ?></td>
                            <td><?= substr($data['jam'], 0, 5); ?></td> <!-- TAMPILKAN JAM -->
                            <td>
                                <a href="ekskul/lihatAnggota.php?id_ekskul=<?= $data['id_ekskul']; ?>" class="btn btn-success">Lihat</a>
                            </td>

                            <td>
                                <a href="ekskul/editekskul.php?id_ekskul=<?= $data['id_ekskul']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="ekskul/deleteekskul.php?id_ekskul=<?= $data['id_ekskul']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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