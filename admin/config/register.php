<?php
include 'connect.php';

// fungsi registrasi siswa
function register_siswa($post)
{
    global $db;
    $nama = $post['nama'];
    $nisn = $post['nisn'];
    $kelas = $post['kelas'];
    $jurusan = $post['jurusan'];

    $query = "INSERT INTO register_siswa (nama_siswa, nisn, kelas, jurusan)
              VALUES ('$nama', '$nisn', '$kelas', '$jurusan')";

    if (!mysqli_query($db, $query)) {
        echo "SQL ERROR: " . mysqli_error($db);
        return false;
    }

    return mysqli_affected_rows($db);
}

// fungsi registrasi guru
function register_guru($post)
{
    global $db;
    $nama = $post['nama'];
    $nip = $post['nip'];

    $query = "INSERT INTO register_guru (nama_guru, nip)
              VALUES ('$nama', '$nip')";
    if (!mysqli_query($db, $query)) {
        echo "SQL ERROR: " . mysqli_error($db);
        return false;
    }

    return mysqli_affected_rows($db);
}

// tampil data siswa
function datasiswa($query) {
    global $db;
    $result = mysqli_query($db, $query);
    if (!$result) {
        return []; // jika query gagal, kembalikan array kosong
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;  // ✔ Ini yang benar
}
$data_siswa = tampildatasiswa("SELECT * FROM register_siswa");


// tampil data guru
function datasguru($query) {
    global $db;
    $result = mysqli_query($db, $query);
    if (!$result) {
        return []; // jika query gagal, kembalikan array kosong
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;  // ✔ Ini yang benar
}
$data_guru = tampildatasiswa("SELECT * FROM register_guru");