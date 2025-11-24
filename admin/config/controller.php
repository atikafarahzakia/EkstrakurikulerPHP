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
    if (!$result) return [];
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) $rows[] = $row;
    return $rows;
}

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

    if ($id_guru <= 0 || empty($ekskul_ids)) return 0;

    // Ambil nama guru
    $rg = mysqli_query($db, "SELECT nama_guru FROM register_guru WHERE id_guru = $id_guru");
    if (!$rg || mysqli_num_rows($rg) == 0) return 0;
    $r = mysqli_fetch_assoc($rg);
    $nama_pembina = mysqli_real_escape_string($db, $r['nama_guru']);

    // Cek pembina sudah ada?
    $cek = mysqli_query($db, "SELECT id_pembina FROM tb_pembina WHERE id_guru = $id_guru");

    if (mysqli_num_rows($cek) == 0) {
        // Insert pembina baru
        $first_ekskul = (int)$ekskul_ids[0];
        mysqli_query($db, "
            INSERT INTO tb_pembina (nama_pembina, id_ekskul, id_guru) 
            VALUES ('$nama_pembina', $first_ekskul, $id_guru)
        ");
    } else {
        // Update id_ekskul utama jika ingin
        $row = mysqli_fetch_assoc($cek);
        $id_pembina = $row['id_pembina'];
        $first_ekskul = (int)$ekskul_ids[0];
        mysqli_query($db, "UPDATE tb_pembina SET nama_pembina='$nama_pembina', id_ekskul=$first_ekskul WHERE id_pembina = $id_pembina");
    }

    // Hapus relasi lama di tb_ekskul_pembina
    mysqli_query($db, "DELETE FROM tb_ekskul_pembina WHERE id_guru = $id_guru");

    // Insert semua relasi baru
    $affected = 0;
    foreach ($ekskul_ids as $ie) {
        $ie = (int)$ie;
        $res = mysqli_query($db, "INSERT INTO tb_ekskul_pembina (id_ekskul, id_guru) VALUES ($ie, $id_guru)");
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
