<?php
    include '../../config/app.php';
    //menerima id barang yang di pilih
    $id = (int)$_GET['id_guru'];

    if (hapus_regisguru($id) > 0) {
        echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = '../dataguru.php';
            </script>";
    } else {
        echo "<script>
            alert('Data gagal dihapus!');
            document.location.href = '../dataguru.php';
            </script>";
    }
?>