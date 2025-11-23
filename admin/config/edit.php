<?php
include 'connect.php';

// edit siswa
function editsiswa($post)
{
    global $db;
    $id = $post['id_siswa'];
    $nama_siswa = $post['nama_siswa'];
    $kelas = $post['kelas'];
    $jurusan = $post['jurusan'];

    // query untuk update
    $query = "UPDATE tb_siswa SET nama_siswa = '$nama_siswa', kelas = '$kelas', jurusan = '$jurusan' WHERE id_siswa = $id";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// edit pembina
function editguru($post)
{
    global $db;
    $id_pembina = (int)$post['id_pembina'];
    $id_guru = isset($post['id_guru']) ? (int)$post['id_guru'] : null;
    $ekskul_ids = isset($post['ekskul_ids']) ? $post['ekskul_ids'] : [];


    // update tb_pembina jika diperlukan
    if ($id_guru) {
        $rg = mysqli_query($db, "SELECT nama_guru FROM register_guru WHERE id_guru = $id_guru");
        if ($rg && mysqli_num_rows($rg) > 0) {
            $r = mysqli_fetch_assoc($rg);
            $nama_pembina = mysqli_real_escape_string($db, $r['nama_guru']);
            mysqli_query($db, "UPDATE tb_pembina SET nama_pembina = '$nama_pembina', id_guru = $id_guru WHERE id_pembina = $id_pembina");
        }
    }


    // update relasi tb_ekskul_pembina
    mysqli_query($db, "DELETE FROM tb_ekskul_pembina WHERE id_pembina = $id_pembina");
    $affected = 0;
    foreach ($ekskul_ids as $ie) {
        $ie = (int)$ie;
        $res = mysqli_query($db, "INSERT INTO tb_ekskul_pembina (id_ekskul, id_pembina) VALUES ($ie, $id_pembina)");
        if ($res) $affected++;
    }


    return $affected;
}

// edit ekskul
function editekskul($post)
{
    global $db;

    $id_ekskul    = $post['id_ekskul'];
    $nama_ekskul  = $post['ekskul'];
    $hari         = $post['hari'];
    $jam          = $post['jam'];

    // Update nama ekskul
    $query1 = "UPDATE tb_ekskul SET nama_ekskul = '$nama_ekskul'
               WHERE id_ekskul = $id_ekskul";

    mysqli_query($db, $query1);

    // Update jadwal ekskul
    $query2 = "UPDATE tb_jadwal SET hari = '$hari', jam = '$jam'
               WHERE id_ekskul = $id_ekskul";

    mysqli_query($db, $query2);

    // Return total perubahan (2 tabel)
    return mysqli_affected_rows($db);
}

// edit registrasi guru
function edit_regisguru($post)
{
    global $db;
    $id = $post['id_guru'];
    $nama = $post['nama'];
    $nip = $post['nip'];
    $ekskul = $post['ekskul'];

    // query untuk update
    $query = "UPDATE register_guru SET nama_guru = '$nama', nip = '$nip', ekskul = '$ekskul' WHERE id_guru = $id";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// edit registrasi guru
function edit_regissiswa($post)
{
    global $db;
    $id = $post['id_siswa'];
    $nama = $post['nama'];
    $nisn = $post['nisn'];
    $kelas = $post['kelas'];
    $jurusan = $post['jurusan'];

    // query untuk update
    $query = "UPDATE register_siswa SET nama_siswa = '$nama', nisn = '$nisn', kelas = '$kelas', jurusan = '$jurusan' WHERE id_siswa = $id";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
