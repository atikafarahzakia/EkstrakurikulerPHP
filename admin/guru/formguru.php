<?php
include '../config/app.php';

// ambil daftar guru dari register_guru
$gurus = mysqli_query($db, "SELECT id_guru, nama_guru FROM register_guru ORDER BY nama_guru");
$ekskuls = mysqli_query($db, "SELECT id_ekskul, nama_ekskul FROM tb_ekskul ORDER BY nama_ekskul");

if (isset($_POST['tambah'])) {
    // kirim ke fungsi yang diperbarui
    if (form_guru($_POST) > 0) {
        echo "<script>alert('Data berhasil ditambahkan!');document.location.href='../dashboard_pembina.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!');document.location.href='../dashboard_pembina.php';</script>";
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

<body>
    <div class="container bg-white p-4 mt-5 rounded shadow">
        <h2 class="text-center text-primary">Tambah Ekskul Pembina</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Pilih Akun Guru</label>
                <select name="id_guru" class="form-control" required>
                    <option value="">-- Pilih Guru --</option>
                    <?php while ($g = mysqli_fetch_assoc($gurus)): ?>
                        <option value="<?= $g['id_guru'] ?>"><?= htmlspecialchars($g['nama_guru']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <label class="form-label">Pilih Ekskul (bisa lebih dari 1)</label>
            <div class="mb-3">
                <?php while ($e = mysqli_fetch_assoc($ekskuls)): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="ekskul_ids[]" value="<?= $e['id_ekskul'] ?>" id="ekskul-<?= $e['id_ekskul'] ?>">
                        <label class="form-check-label" for="ekskul-<?= $e['id_ekskul'] ?>"><?= htmlspecialchars($e['nama_ekskul']) ?></label>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="d-grid">
                <button type="submit" name="tambah" class="btn btn-success">Daftar</button>
            </div>
        </form>
    </div>
    <div class="container d-grid">
        <a href="../dashboard_pembina.php" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</body>

</html>