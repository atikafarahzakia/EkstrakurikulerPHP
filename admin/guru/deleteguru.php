<?php
include '../config/app.php'; // pastikan $db sudah terdefinisi

if (!isset($_GET['id_pembina'])) {
    die("ERROR: id_pembina tidak ditemukan.");
}

$id_pembina = (int)$_GET['id_pembina'];

// Ambil id_guru
$res = mysqli_query($db, "SELECT id_guru FROM tb_pembina WHERE id_pembina = $id_pembina");
if (!$res || mysqli_num_rows($res) == 0) {
    die("ERROR: Pembina tidak ditemukan.");
}
$row = mysqli_fetch_assoc($res);
$id_guru = (int)$row['id_guru'];

// Hapus semua relasi ekskul
$delEkskul = mysqli_query($db, "DELETE FROM tb_ekskul_pembina WHERE id_guru = $id_guru");
if (!$delEkskul) {
    die("ERROR: Gagal hapus relasi ekskul. " . mysqli_error($db));
}

// Hapus data pembina
$delPembina = mysqli_query($db, "DELETE FROM tb_pembina WHERE id_pembina = $id_pembina");
if (!$delPembina) {
    die("ERROR: Gagal hapus pembina. " . mysqli_error($db));
}

echo "<script>alert('Pembina berhasil dihapus.');window.location.href='../dashboard_pembina.php';</script>";
