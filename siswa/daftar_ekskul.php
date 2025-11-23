<?php
include 'config/app.php';
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
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="daftar_ekskul.php">Daftar Ekstrakurikuler</a></li>
                        <li class="nav-item"><a class="nav-link" href="join.php">Join Ekstrakurikuler</a></li>
                        <li class="nav-item ms-auto"><a href="logout.php" class="btn btn-danger">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container mt-5 p-4 shadow bg-white rounded">
            <h3 class="text-center">Daftar Ekstrakurikuler</h3>
            <h5 class="text-center">SMK NEGERI 7 SAMARINDA</h5>

            <table class="table table-bordered table-striped table-hover mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Ekskul</th>
                        <th>Pembina</th>
                        <th>Hari Pelatihan</th>
                        <th>Jam Pelatihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data_ekskul as $data): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['nama_ekskul']; ?></td>
                            <td><?= $data['nama_pembina']; ?></td>
                            <td><?= $data['hari']; ?></td>
                            <td><?= substr($data['jam'], 0, 5); ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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