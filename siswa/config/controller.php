<?php   
include 'C:\xampp\htdocs\ekskul2025\admin\config\connect.php';

// Ambil id_siswa dari session
$id_siswa = $_SESSION['id_siswa']; // tambahkan ini

function tampildata_ekskul($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    if (!$result) {
        return [];
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
$data_ekskul = mysqli_query($db, "
    SELECT e.id_ekskul, e.nama_ekskul, j.hari, j.jam, p.nama_pembina
    FROM tb_ekskul e
    LEFT JOIN tb_pembina p ON p.id_ekskul = e.id_ekskul
    LEFT JOIN tb_jadwal j ON j.id_ekskul = e.id_ekskul
");


?>
