<?php
include 'connect.php';

function editekskul($post)
{
    global $db; // gunakan koneksi global

    // Ambil data dari form dan amankan input
    $id_ekskul    = (int)$post['id_ekskul']; // konversi ke integer
    $nama_ekskul  = mysqli_real_escape_string($db, $post['ekskul']);
    $hari         = mysqli_real_escape_string($db, $post['hari']);
    $jam          = mysqli_real_escape_string($db, $post['jam']);

    // Update nama ekskul di tabel utama
    mysqli_query($db, "UPDATE tb_ekskul SET nama_ekskul = '$nama_ekskul' WHERE id_ekskul = $id_ekskul");

    // Cek apakah jadwal ekskul sudah ada di database
    $cek = mysqli_query($db, "SELECT id_jadwal FROM tb_jadwal WHERE id_ekskul = $id_ekskul");

    if (mysqli_num_rows($cek) > 0) {
        // Jika ada → Update jadwal
        mysqli_query($db, "UPDATE tb_jadwal SET hari = '$hari', jam = '$jam' WHERE id_ekskul = $id_ekskul");
    } else {
        // Jika belum ada → Tambahkan jadwal baru
        mysqli_query($db, "INSERT INTO tb_jadwal (id_ekskul, hari, jam) VALUES ($id_ekskul, '$hari', '$jam')");
    }

    // Mengembalikan status sukses/ubah data
    return mysqli_affected_rows($db); // bernilai >0 jika berhasil
}

function tampildata($query) {
    global $db; 

    $result = mysqli_query($db, $query); // jalankan query
    if (!$result) {
        die("Query gagal: " . mysqli_error($db)); // tampilkan error jika gagal
    }

    // simpan hasil query dalam array
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows; // return array berisi data terformat
}
