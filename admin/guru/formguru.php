<?php
include '../config/app.php'; // pastikan $db sudah terdefinisi

// Ambil daftar guru dan ekskul
$gurus = mysqli_query($db, "SELECT id_guru, nama_guru FROM register_guru ORDER BY nama_guru");
$ekskuls = mysqli_query($db, "SELECT id_ekskul, nama_ekskul FROM tb_ekskul ORDER BY nama_ekskul");

// Proses simpan
if (isset($_POST['simpan'])) {
    $id_guru = (int)$_POST['id_guru'];
    $ekskul_ids = isset($_POST['ekskul_ids']) ? $_POST['ekskul_ids'] : [];

    if ($id_guru > 0 && !empty($ekskul_ids)) {
        $rg = mysqli_query($db, "SELECT nama_guru FROM register_guru WHERE id_guru = $id_guru");
        if (!$rg) {
            die("Error query register_guru: " . mysqli_error($db));
        }
        $r = mysqli_fetch_assoc($rg);
        $nama_pembina = mysqli_real_escape_string($db, $r['nama_guru']);

        $first_ekskul = (int)$ekskul_ids[0];

        $insert = mysqli_query($db, "INSERT INTO tb_pembina (nama_pembina, id_ekskul, id_guru) VALUES ('$nama_pembina', $first_ekskul, $id_guru)");
        if (!$insert) {
            die("Error insert tb_pembina: " . mysqli_error($db));
        }

        $id_pembina = mysqli_insert_id($db);

        foreach ($ekskul_ids as $ie) {
            $ie = (int)$ie;
            $res = mysqli_query($db, "INSERT INTO tb_ekskul_pembina (id_ekskul, id_guru) VALUES ($ie, $id_guru)");
            if (!$res) {
                die("Error insert tb_ekskul_pembina: " . mysqli_error($db));
            }
        }


        echo "<script>alert('Data pembina berhasil disimpan!');window.location.href='../dashboard_pembina.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Pilih guru dan minimal 1 ekskul!');</script>";
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Pembina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container bg-white p-4 mt-5 rounded shadow">
        <h2 class="text-center text-primary">Tambah Pembina</h2>
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
                <button type="submit" name="simpan" class="btn btn-success">Tambah Pembina</button>
            </div>
        </form>
    </div>
    <div class="container d-grid mt-3">
        <a href="../dashboard_pembina.php" class="btn btn-secondary">Kembali</a>
    </div>
</body>

</html>