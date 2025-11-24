<?php
include '../config/app.php';

// Pastikan URL mengirim id_pembina
if (!isset($_GET['id_pembina'])) {
    die("ERROR: id_pembina tidak ditemukan di URL");
}

$id_pembina = (int)$_GET['id_pembina'];

// Ambil data pembina berdasarkan id_pembina
$result = mysqli_query($db, "SELECT * FROM tb_pembina WHERE id_pembina = $id_pembina");
if (!$result) die("Query gagal: " . mysqli_error($db));

$guru = mysqli_fetch_assoc($result);
if (!$guru) die("ERROR: Data guru dengan ID $id_pembina tidak ditemukan.");

// Ambil semua ekskul yang dipegang pembina ini
$selectedEkskul = [];
$q = mysqli_query($db, "SELECT id_ekskul FROM tb_ekskul_pembina WHERE id_guru = {$guru['id_guru']}");
if ($q) {
    while ($r = mysqli_fetch_assoc($q)) {
        $selectedEkskul[] = $r['id_ekskul'];
    }
}

// Proses update jika form disubmit
if (isset($_POST['ubah'])) {
    $id_guru = (int)$_POST['id_guru'];
    $ekskul_ids = isset($_POST['ekskul_ids']) ? $_POST['ekskul_ids'] : [];

    // Update nama pembina
    $nama = mysqli_real_escape_string($db, $_POST['nama_pembina']);
    mysqli_query($db, "UPDATE tb_pembina SET nama_pembina='$nama' WHERE id_pembina=$id_pembina");

    // Hapus relasi lama
    mysqli_query($db, "DELETE FROM tb_ekskul_pembina WHERE id_guru=$id_guru");

    // Insert relasi baru
    foreach ($ekskul_ids as $ie) {
        $ie = (int)$ie;
        mysqli_query($db, "INSERT INTO tb_ekskul_pembina (id_ekskul, id_guru) VALUES ($ie, $id_guru)");
    }

    echo "<script>
        alert('Data berhasil disimpan');
        window.location.href='../dashboard_pembina.php';
    </script>";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Guru/Pembina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:whitesmoke;">
<div class="container bg-white p-4 mt-5 rounded shadow">
    <h2 class="text-center text-primary">Form Edit Guru/Pembina</h2>
    <form action="" method="POST">
        <!-- Hidden ID -->
        <input type="hidden" name="id_guru" value="<?= $guru['id_guru']; ?>">

        <!-- Nama Pembina -->
        <div class="mb-3">
            <label class="form-label">Nama Guru/Pembina</label>
            <input type="text" name="nama_pembina" class="form-control" value="<?= htmlspecialchars($guru['nama_pembina']); ?>" required>
        </div>

        <!-- Pilih Ekstrakurikuler -->
        <label class="form-label">Ekstrakurikuler</label>
        <div class="mb-3">
            <?php
            $query = mysqli_query($db, "SELECT id_ekskul, nama_ekskul FROM tb_ekskul");
            if ($query) {
                while ($row = mysqli_fetch_assoc($query)) {
                    $checked = in_array($row['id_ekskul'], $selectedEkskul) ? 'checked' : '';
                    echo "<div class='form-check'>
                            <input class='form-check-input' type='checkbox' name='ekskul_ids[]' value='{$row['id_ekskul']}' id='ekskul-{$row['id_ekskul']}' $checked>
                            <label class='form-check-label' for='ekskul-{$row['id_ekskul']}'>{$row['nama_ekskul']}</label>
                          </div>";
                }
            }
            ?>
        </div>

        <!-- Submit -->
        <div class="d-grid">
            <button type="submit" name="ubah" class="btn btn-success">Simpan Perubahan</button>
        </div>
    </form>
</div>

<div class="container d-grid mt-3">
    <a href="../dashboard_pembina.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
