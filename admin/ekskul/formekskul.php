<?php
include '../config/app.php';
if (isset($_POST['tambah'])) {
    if (form_ekskul($_POST) > 0) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            document.location.href = '../dashboard_ekskul.php';
            </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
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

                <div class="mb-3">
                    <label class="form-label">Nama Ekstrakurikuler</label>
                    <input type="text" name="ekskul" class="form-control" required>
                </div>

                <label class="form-label">Hari Pelatihan</label>
                <select class="form-select mb-3" name="hari" required>
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
                    <input type="time" name="jam" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>

        <div class="container d-grid">
            <a href="../dashboard_ekskul.php" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</body>

</html>