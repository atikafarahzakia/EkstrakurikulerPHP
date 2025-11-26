<?php
include 'connect.php';

// fungsi tampil data siswa
function tampildatasiswa($query)
{
    global $db; // mengambil variabel koneksi
    $result = mysqli_query($db, $query); // menjalankan query

    if (!$result) {
        return []; // jika query error, kembalikan array kosong
    }

    $rows = []; // wadah untuk menampung data

    // ambil semua data hasil query dalam bentuk array asosiatif
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows; // mengembalikan data ke pemanggil fungsi
}

// memanggil fungsi untuk menampilkan semua siswa
$data_siswa = tampildatasiswa("SELECT * FROM tb_siswa");

// fungsi tampil data guru
function tampildataguru($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    if (!$result) return [];

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) $rows[] = $row;

    return $rows;
}

// query untuk menampilkan data guru + ekskul yang dibina
$dataGURU = tampildataguru("
    SELECT 
        p.id_pembina, 
        p.nama_pembina,
        GROUP_CONCAT(e.nama_ekskul ORDER BY e.nama_ekskul SEPARATOR ', ') AS nama_ekskul
    FROM tb_pembina p
    LEFT JOIN tb_ekskul_pembina ep ON ep.id_pembina = p.id_pembina
    LEFT JOIN tb_ekskul e ON ep.id_ekskul = e.id_ekskul
    GROUP BY p.id_pembina
");


// ===============================================================
// FUNGSI MENAMPILKAN DATA EKSKUL + JADWAL
// ===============================================================
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

// ambil data ekskul + jadwal
$data_ekskul = tampildata_ekskul("
    SELECT tb_ekskul.id_ekskul, tb_ekskul.nama_ekskul, tb_jadwal.hari, tb_jadwal.jam
    FROM tb_ekskul
    JOIN tb_jadwal ON tb_ekskul.id_ekskul = tb_jadwal.id_ekskul
");


// ===============================================================
// FUNGSI FORM TAMBAH SISWA
// ===============================================================
function form_siswa($post)
{
    global $db;

    $nama_siswa = $post['nama_siswa'];
    $kelas      = $post['kelas'];
    $jurusan    = $post['jurusan'];

    // query insert data siswa
    $query = "INSERT INTO tb_siswa VALUES(null, '$nama_siswa','$kelas','$jurusan')";

    mysqli_query($db, $query);

    // mengembalikan jumlah baris yang terpengaruh
    return mysqli_affected_rows($db);
}


// ===============================================================
// FUNGSI FORM TAMBAH PEMBINA (GURU)
// ===============================================================
function form_guru($post)
{
    global $db;

    // id_guru dari form
    $id_guru = (int)$post['id_guru'];

    // daftar ekskul yang dipilih
    $ekskul_ids = isset($post['ekskul_ids']) ? $post['ekskul_ids'] : [];

    // validasi awal
    if ($id_guru <= 0 || empty($ekskul_ids)) return 0;

    // cek nama guru berdasarkan id_guru
    $rg = mysqli_query($db, "SELECT nama_guru FROM register_guru WHERE id_guru = $id_guru");
    if (!$rg || mysqli_num_rows($rg) == 0) return 0;

    $r = mysqli_fetch_assoc($rg);
    $nama_pembina = mysqli_real_escape_string($db, $r['nama_guru']);

    // cek apakah guru sudah jadi pembina sebelumnya
    $cek = mysqli_query($db, "SELECT id_pembina FROM tb_pembina WHERE id_guru = $id_guru");

    if (mysqli_num_rows($cek) == 0) {

        // jika belum pernah, insert pembina baru (1 ekskul utama)
        $first_ekskul = (int)$ekskul_ids[0];

        mysqli_query($db, "
            INSERT INTO tb_pembina (nama_pembina, id_ekskul, id_guru) 
            VALUES ('$nama_pembina', $first_ekskul, $id_guru)
        ");

    } else {

        // jika sudah ada, update ekskul utama
        $row = mysqli_fetch_assoc($cek);
        $id_pembina = $row['id_pembina'];

        $first_ekskul = (int)$ekskul_ids[0];

        mysqli_query($db, "
            UPDATE tb_pembina 
            SET nama_pembina='$nama_pembina', id_ekskul=$first_ekskul 
            WHERE id_pembina = $id_pembina
        ");
    }

    // hapus relasi guru ↔ ekskul agar tidak dobel
    mysqli_query($db, "DELETE FROM tb_ekskul_pembina WHERE id_guru = $id_guru");

    // insert ulang semua ekskul yang dipilih
    $affected = 0;
    foreach ($ekskul_ids as $ie) {
        $ie = (int)$ie;
        $res = mysqli_query($db, "INSERT INTO tb_ekskul_pembina (id_ekskul, id_guru) VALUES ($ie, $id_guru)");
        if ($res) $affected++; // hitung yang berhasil
    }

    return $affected; // mengembalikan jumlah ekskul yang diinput
}


// ===============================================================
// FUNGSI TAMBAH EKSKUL BARU + JADWAL
// ===============================================================
function form_ekskul($post)
{
    global $db;

    $nama_ekskul = $post['ekskul'];
    $hari        = $post['hari'];
    $jam         = $post['jam'];

    // Insert ekskul baru
    $query = "INSERT INTO tb_ekskul (nama_ekskul)
              VALUES ('$nama_ekskul')";
    $insert1 = mysqli_query($db, $query);

    if (!$insert1) {
        echo "Error Insert Ekskul: " . mysqli_error($db);
        return 0;
    }

    // ambil id ekskul yang baru ditambahkan
    $id_ekskul = mysqli_insert_id($db);

    // Insert jadwal berdasarkan id ekskul
    $query2 = "INSERT INTO tb_jadwal (id_ekskul, hari, jam)
               VALUES ('$id_ekskul', '$hari', '$jam')";
    $insert2 = mysqli_query($db, $query2);

    if (!$insert2) {
        echo "Error Insert Jadwal: " . mysqli_error($db);
        return 0;
    }

    return 1; // sukses
}
