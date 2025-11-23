<?php
    include '../../config/app.php';
    //menerima id barang yang di pilih
    $id = (int)$_GET['id_siswa'];

    if (hapus_regissiswa($id) > 0) {
        echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = '../datasiswa.php';
            </script>";
    } else {
        echo "<script>
            alert('Data gagal dihapus!');
            document.location.href = '../datasiswa.php';
            </script>";
    }
?>