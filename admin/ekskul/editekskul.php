<?php
include '../config/app.php';

if (!isset($_GET['id_ekskul'])) {
    die("ERROR: id_ekskul tidak ditemukan di URL");
}

// Mengubah id_ekskul menjadi integer agar aman
$id = (int)$_GET['id_ekskul'];

// Fungsi tampildata_ekskul() digunakan untuk mengambil data dari database
// Query ini mengambil data ekskul + jadwal dengan LEFT JOIN agar jadwal bisa NULL
$ekskul = tampildata_ekskul("
    SELECT 
        tb_ekskul.id_ekskul,
        tb_ekskul.nama_ekskul AS ekskul,
        tb_jadwal.hari,
        tb_jadwal.jam
    FROM tb_ekskul
    LEFT JOIN tb_jadwal 
        ON tb_jadwal.id_ekskul = tb_ekskul.id_ekskul
    WHERE tb_ekskul.id_ekskul = $id
")[0]; 
// [0] karena fungsi tampildata_ekskul mengembalikan array data

if (isset($_POST['ubah'])) {

    // Fungsi editEkskul() menangani proses update ke database
    if (editekskul($_POST) > 0) {
        // Jika berhasil
        echo "<script>
            alert('Selamat, data berhasil disimpan');
            document.location.href = '../dashboard_ekskul.php';
        </script>";
    } else {
        // Jika gagal
        echo "<script>
            alert('Data gagal disimpan');
            document.location.href = '../dashboard_ekskul.php';
        </script>";
    }
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Ekskul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="">
        <div class="container bg-white p-4 mt-5 rounded shadow">
            <h2 class="text-center text-primary">Tambah Ekstrakurikuler</h2>
            <form action="" method="POST">
                <!-- membuat id hidden -->
                <input type="hidden" name="id_ekskul" value="<?= $ekskul['id_ekskul']; ?>">
                <!-- ================= -->
                <div class="mb-3">
                    <label class="form-label">Nama Ekstrakurikuler</label>
                    <input type="text" name="ekskul" class="form-control" required value="<?= $ekskul['ekskul']; ?>">
                </div>

                <label class="form-label">Hari Pelatihan</label>
                <select class="form-select mb-3" name="hari" required value="<?= $ekskul['hari']; ?>">
                    <option value="" selected>Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
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
            <a href="../dashboard_ekskul.php" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</body>

</html>