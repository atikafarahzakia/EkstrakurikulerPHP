<?php
include '../config/app.php';

// Pastikan id_pembina dikirim lewat URL
if (!isset($_GET['id_pembina'])) {
    die("ERROR: id_pembina tidak ditemukan.");
}

// Mengonversi id_pembina menjadi integer agar aman
$id_pembina = (int)$_GET['id_pembina'];

// Ambil id_guru berdasarkan id_pembina (karena tabel relasinya butuh id_guru)
$res = mysqli_query($db, "SELECT id_guru FROM tb_pembina WHERE id_pembina = $id_pembina");

// Jika query gagal atau tidak ada datanya
if (!$res || mysqli_num_rows($res) == 0) {
    die("ERROR: Pembina tidak ditemukan.");
}

$row = mysqli_fetch_assoc($res);
// Simpan id_guru yang ditemukan
$id_guru = (int)$row['id_guru'];

// Hapus seluruh hubungan ekskul yang dimiliki guru pada tabel relasi 'tb_ekskul_pembina'
$delEkskul = mysqli_query($db, "DELETE FROM tb_ekskul_pembina WHERE id_guru = $id_guru");

// Jika penghapusan relasi gagal
if (!$delEkskul) {
    die("ERROR: Gagal hapus relasi ekskul. " . mysqli_error($db));
}

// Hapus data pembina dari tabel utama tb_pembina
$delPembina = mysqli_query($db, "DELETE FROM tb_pembina WHERE id_pembina = $id_pembina");

// Jika penghapusan data pembina gagal
if (!$delPembina) {
    die("ERROR: Gagal hapus pembina. " . mysqli_error($db));
}

// Jika semua berhasil, tampilkan pesan dan kembali ke dashboard
echo "<script>
        alert('Pembina berhasil dihapus.');
        window.location.href='../dashboard_pembina.php';
      </script>";
?>
