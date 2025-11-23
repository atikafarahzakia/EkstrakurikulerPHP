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

    $password = password_hash($nisn, PASSWORD_DEFAULT);

    $query = "INSERT INTO register_siswa (nama_siswa, nisn, kelas, jurusan, password)
              VALUES ('$nama', '$nisn', '$kelas', '$jurusan', '$password')";

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
    $ekskul = $post['ekskul'];

    $password = password_hash($nip, PASSWORD_DEFAULT);

    $query = "INSERT INTO register_guru (nama_guru, nip, ekskul, password)
              VALUES ('$nama', '$nip', '$ekskul', '$password')";

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






// // fungsi login siswa
// function login_siswa($post)
// {
//     global $db;
//     $nisn = $post['nisn'];
//     $password = $post['password'];

//     $query = mysqli_query($db, "SELECT * FROM tb_siswa WHERE nisn='$nisn'");
//     $data  = mysqli_fetch_assoc($query);

//     if ($data && password_verify($password, $data['password'])) {
//         session_start();
//         $_SESSION['login'] = true;
//         $_SESSION['user_id'] = $data['id_siswa'];
//         $_SESSION['nama'] = $data['nama_siswa'];
//         $_SESSION['role'] = "siswa";
//         return true;
//     }

//     return false;
// }
