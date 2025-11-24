<?php
include 'C:\xampp\htdocs\ekskul2025\admin\config\connect.php';

// Ambil id_siswa dari session
$id_siswa = $_SESSION['id_siswa']; // tambahkan ini

// Ambil data semua ekskul beserta pembina (jika ada) dan jadwal
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

// Query untuk menampilkan semua ekskul, tetap tampil walau pembina NULL
$data_ekskul = tampildata_ekskul("
    SELECT 
        e.id_ekskul,
        e.nama_ekskul,
        IFNULL(g.nama_guru, '-') AS nama_pembina,
        IFNULL(j.hari, '-') AS hari,
        IFNULL(j.jam, '-') AS jam
    FROM tb_ekskul e
    LEFT JOIN tb_ekskul_pembina ep ON ep.id_ekskul = e.id_ekskul
    LEFT JOIN register_guru g ON g.id_guru = ep.id_guru
    LEFT JOIN tb_jadwal j ON j.id_ekskul = e.id_ekskul
    ORDER BY e.nama_ekskul ASC
");

