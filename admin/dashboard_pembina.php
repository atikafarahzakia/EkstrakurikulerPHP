<?php
include 'config/app.php'; 

$dataGURU = []; // Array untuk menampung hasil data guru

// Query untuk menampilkan daftar pembina beserta ekskul yang dibina
$query = "
    SELECT 
        p.id_pembina,                        -- Ambil ID pembina
        p.nama_pembina,                      -- Ambil nama pembina
        GROUP_CONCAT(e.nama_ekskul SEPARATOR ', ') AS ekskul_list  -- Gabungkan nama ekskul menjadi satu baris
    FROM tb_pembina p
    LEFT JOIN tb_ekskul_pembina ep ON ep.id_guru = p.id_guru       -- Hubungkan pembina dengan tabel penghubung
    LEFT JOIN tb_ekskul e ON e.id_ekskul = ep.id_ekskul             -- Ambil nama ekskul dari id ekskul
    GROUP BY p.id_pembina, p.nama_pembina                          -- Grup berdasarkan pembina agar tidak duplikat
    ORDER BY p.id_pembina ASC                                      -- Urutkan berdasarkan ID dari kecil ke besar
";

$result = mysqli_query($db, $query); // Eksekusi query

// Validasi jika query gagal
if (!$result) {
    die("Query gagal: " . mysqli_error($db));
}

// Simpan hasil query ke array
while ($row = mysqli_fetch_assoc($result)) {
    $dataGURU[] = $row;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Pembina/guru</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Ekstrakurikuler SMK7</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="dashboard_ekskul.php">Ekstrakurikuler</a></li>
                        <li class="nav-item"><a class="nav-link" href="dashboard_pembina.php">Pembina/guru</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown">Register Akun</a>
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

    <main class="flex-grow-1">
        <div class="container bg-white p-4 mt-5 rounded shadow">
            <h2 class="text-center">PEMBINA</h2>
            <hr>
            <div class="d-grid gap-2 mt-3">
                <a href="guru/formguru.php" class="btn btn-success">Tambah data pembina</a>
            </div>
            <h2 class="mt-5">Daftar Pembina</h2>
            <!-- <form class="d-flex mt-2">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
            <table class="table table-striped table-hover table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Pembina</th>
                        <th>Ekstrakurikuler</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($dataGURU as $data): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($data['nama_pembina']); ?></td>
                            <td><?= $data['ekskul_list'] ?? '-'; ?></td>
                            <td>
                                <a href="guru/editguru.php?id_pembina=<?= $data['id_pembina']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="guru/deleteguru.php?id_pembina=<?= $data['id_pembina']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0">© 2025 Atika Farah Zakia XI PPLG 2</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>