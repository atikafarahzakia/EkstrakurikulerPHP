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

    $id_guru = (int)$post['id_guru'];
    $ekskul_ids = isset($post['ekskul_ids']) ? $post['ekskul_ids'] : [];


    // (Opsional) Masukkan ke tb_pembina kalau kamu ingin tetap menyimpan nama pembina
    // Cek apakah sudah ada pembina dengan id_guru ini
    $cek = mysqli_query($db, "SELECT id_pembina FROM tb_pembina WHERE id_guru = $id_guru");
    if (mysqli_num_rows($cek) == 0) {
        // ambil nama guru
        $rg = mysqli_query($db, "SELECT nama_guru FROM register_guru WHERE id_guru = $id_guru");
        $r = mysqli_fetch_assoc($rg);
        $nama_pembina = mysqli_real_escape_string($db, $r['nama_guru']);
        mysqli_query($db, "INSERT INTO tb_pembina (nama_pembina, id_ekskul, id_guru) VALUES ('$nama_pembina', NULL, $id_guru)");
        $id_pembina = mysqli_insert_id($db);
    } else {
        $row = mysqli_fetch_assoc($cek);
        $id_pembina = $row['id_pembina'];
    }

    // Simpan relasi ke tb_ekskul_pembina
    // Hapus relasi lama untuk id_pembina ini (jika ingin replace)
    mysqli_query($db, "DELETE FROM tb_ekskul_pembina WHERE id_pembina = $id_pembina");


    $affected = 0;
    foreach ($ekskul_ids as $ie) {
        $ie = (int)$ie;
        $res = mysqli_query($db, "INSERT INTO tb_ekskul_pembina (id_ekskul, id_pembina) VALUES ($ie, $id_pembina)");
        if ($res) $affected++;
    }

    return $affected;
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
