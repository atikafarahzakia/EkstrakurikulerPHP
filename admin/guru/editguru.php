<?php
include '../config/app.php';
if (!isset($_GET['id_pembina'])) {
    die("ERROR: id_pembina tidak ditemukan di URL");
}


// CEK apakah URL mengirim id_pembina
if (!isset($_GET['id_pembina'])) {
    die("ERROR: id_pembina tidak ditemukan di URL");
}

$id = (int)$_GET['id_pembina'];

// AMBIL DATA PEMBINA BERDASARKAN ID
$guru = tampildataguru("SELECT * FROM tb_pembina WHERE id_pembina = $id")[0];

// cek apakah tombol simpan ditekan akan bertambah
if (isset($_POST['ubah'])) {
    if (editguru($_POST) > 0) {
        echo "<script>
            alert('selamat data anda berhasil di simpan');
            document.location.href = '../dashboard_pembina.php';
            </script>";
    } else {
        echo "<script>
            alert('data anda gagal di simpan');
            document.location.href = '../dashboard_pembina.php';
            </script>";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color:whitesmoke;">
    <div class="container bg-white p-4 mt-5 rounded shadow">
        <h2 class="text-center text-primary">Form Pendaftaran Guru</h2>
        <form action="" method="POST">
            <!-- membuat id hidden -->
            <input type="hidden" name="id_pembina" value="<?= $guru['id_pembina']; ?>">
            <!-- ================= -->
            <div class="mb-3">
                <label class="form-label">Nama guru/pembina</label>
                <input type="text" name="nama_pembina" class="form-control" value="<?= $guru['nama_pembina']; ?>">
            </div>
            <select class="form-select mb-3" aria-label="Default select example" name="id_ekskul" value="<?= $guru['id_ekskul']; ?>">
                <option selected>PILIH Ekstrakurikuler
                    <?php
                    $query = mysqli_query($db, "SELECT id_ekskul, nama_ekskul FROM tb_ekskul");
                    while ($row = mysqli_fetch_assoc($query)) {
                        $selected = ($row['id_ekskul'] == $guru['id_ekskul']) ? 'selected' : '';
                        echo "<option value='{$row['id_ekskul']}' $selected>{$row['nama_ekskul']}</option>";
                    }
                    ?>
                </option>
            </select>
            <div class="d-grid">
                <button type="submit" name="ubah" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </form>

    </div>
    <div class="container d-grid">
        <a href="../dashboard.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>

</html>