<?php
include 'connect.php';

// fungsi menampilkan data siswa
function tampildatasiswa($query)
{
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
$data_siswa = tampildatasiswa("SELECT * FROM tb_siswa");

// fungsi menampilkan data pembina
function tampildataguru($query)
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
$dataGURU = tampildataguru("
    SELECT tb_pembina.nama_pembina, tb_pembina.id_pembina, tb_ekskul.nama_ekskul
    FROM tb_pembina
    LEFT JOIN tb_ekskul ON tb_pembina.id_ekskul = tb_ekskul.id_ekskul
");


// fungsi menampilkan data ekskul
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
    return $rows;  // ✔ Ini yang benar
}
$data_ekskul = tampildata_ekskul("
    SELECT tb_ekskul.id_ekskul, tb_ekskul.nama_ekskul, tb_jadwal.hari, tb_jadwal.jam
    FROM tb_ekskul
    JOIN tb_jadwal ON tb_ekskul.id_ekskul = tb_jadwal.id_ekskul
");


// fungsi menampilkan data pendaftaran
function data_pendaftaran($query)
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
    return $rows;  // ✔ Ini yang benar
}
$data_pen = data_pendaftaran("SELECT * FROM tb_pendaftaran");

// ====================================================================TAMBAH DATA==================================================================

// fungsi form siswa
function form_siswa($post)
{
    global $db;
    $nama_siswa = $post['nama_siswa'];
    $kelas = $post['kelas'];
    $jurusan = $post['jurusan'];

    // query tambah data
    $query = "INSERT INTO tb_siswa VALUES(null, '$nama_siswa','$kelas','$jurusan')";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// fungsi form guru
function form_guru($post)
{
    global $db;
    $nama_pembina = $post['nama_pembina'];
    $nama_ekskul  = $post['ekskul'];

    // ✅ ambil id_ekskul dari nama ekskul
    $query_ekskul = mysqli_query($db, "SELECT id_ekskul FROM tb_ekskul WHERE nama_ekskul = '$nama_ekskul'");
    if (!$query_ekskul) {
        return 0;
    }
    $data_ekskul = mysqli_fetch_assoc($query_ekskul);
    $id_ekskul = $data_ekskul['id_ekskul'] ?? null;

    // kalau tidak ketemu, gagal
    if (!$id_ekskul) {
        return 0;
    }

    // ✅ query tambah data
    $query = "INSERT INTO tb_pembina (nama_pembina, id_ekskul)
              VALUES ('$nama_pembina', '$id_ekskul')";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// fungsi form ekskul
function form_ekskul($post)
{
    global $db;
    $nama_ekskul = $post['ekskul'];
    $hari        = $post['hari'];
    $jam         = $post['jam'];

    // tambah ekskul
    $query = "INSERT INTO tb_ekskul (nama_ekskul)
              VALUES ('$nama_ekskul')";
    $insert1 = mysqli_query($db, $query);

    if (!$insert1) {
        echo "Error Insert Ekskul: " . mysqli_error($db);
        return 0;
    }

    // ambil id ekskul terbaru
    $id_ekskul = mysqli_insert_id($db);

    // tambah jadwal
    $query2 = "INSERT INTO tb_jadwal (id_ekskul, hari, jam)
               VALUES ('$id_ekskul', '$hari', '$jam')";
    $insert2 = mysqli_query($db, $query2);

    if (!$insert2) {
        echo "Error Insert Jadwal: " . mysqli_error($db);
        return 0;
    }

    return 1;
}

//fungsi pendaftaran siswa
function pendaftaran($post)
{
    global $db;
    $nama_siswa = mysqli_real_escape_string($db, $post['siswa']);
    $kelas = mysqli_real_escape_string($db, $post['kelas']);
    $gender = mysqli_real_escape_string($db, $post['gender']);
    $nowa = mysqli_real_escape_string($db, $post['nowa']);
    $ekskul = mysqli_real_escape_string($db, $post['ekskul']);
    $tanggal = mysqli_real_escape_string($db, $post['tanggal']);

    $query = "INSERT INTO tb_pendaftaran (nama, kelas, jenis_kelamin, no_wa, ekskul_dipilih, tanggal_pendaftaran)
              VALUES ('$nama_siswa', '$kelas', '$gender', '$nowa', '$ekskul', '$tanggal')";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
