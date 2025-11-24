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
    $nama_pembina = isset($post['nama_pembina']) ? mysqli_real_escape_string($db, $post['nama_pembina']) : '';
    $ekskul_ids = isset($post['ekskul_ids']) ? $post['ekskul_ids'] : [];

    // Update nama pembina di tb_pembina
    $update = mysqli_query($db, "UPDATE tb_pembina SET nama_pembina = '$nama_pembina' WHERE id_pembina = $id_pembina");

    // Hapus relasi lama di tb_ekskul_pembina
    mysqli_query($db, "DELETE FROM tb_ekskul_pembina WHERE id_pembina = $id_pembina");

    // Insert relasi baru
    $affected = 0;
    foreach ($ekskul_ids as $ie) {
        $ie = (int)$ie;
        if ($ie > 0) {
            $res = mysqli_query($db, "INSERT INTO tb_ekskul_pembina (id_ekskul, id_pembina) VALUES ($ie, $id_pembina)");
            if ($res) $affected++;
        }
    }

    // Jika update nama sukses + ada insert relasi baru, return total affected
    return $affected + ($update ? 1 : 0);
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

    // query untuk update
    $query = "UPDATE register_guru SET nama_guru = '$nama', nip = '$nip' WHERE id_guru = $id";
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
