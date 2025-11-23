<?php
    include '../config/app.php';
    //menerima id barang yang di pilih
    $id = (int)$_GET['id_pembina'];

    if (deleteguru($id) > 0) {
        echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = '../dashboard_pembina.php';
            </script>";
    } else {
        echo "<script>
            alert('Data barang gagal dihapus!');
            document.location.href = '../dashboard_pembina.php';
            </script>";
    }
?>