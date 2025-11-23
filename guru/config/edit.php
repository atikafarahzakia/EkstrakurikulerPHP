<?php
include 'connect.php';

// edit ekskul
function editekskul($post)
{
    global $db;

    $id_ekskul    = (int)$post['id_ekskul'];
    $nama_ekskul  = mysqli_real_escape_string($db, $post['ekskul']);
    $hari         = mysqli_real_escape_string($db, $post['hari']);
    $jam          = mysqli_real_escape_string($db, $post['jam']);

    // Update nama ekskul
    mysqli_query($db, "UPDATE tb_ekskul SET nama_ekskul = '$nama_ekskul' WHERE id_ekskul = $id_ekskul");

    // Cek apakah jadwal sudah ada
    $cek = mysqli_query($db, "SELECT id_jadwal FROM tb_jadwal WHERE id_ekskul = $id_ekskul");
    if (mysqli_num_rows($cek) > 0) {
        // Update jadwal
        mysqli_query($db, "UPDATE tb_jadwal SET hari = '$hari', jam = '$jam' WHERE id_ekskul = $id_ekskul");
    } else {
        // Insert jadwal baru
        mysqli_query($db, "INSERT INTO tb_jadwal (id_ekskul, hari, jam) VALUES ($id_ekskul, '$hari', '$jam')");
    }

    return mysqli_affected_rows($db);
}


// // edit siswa
// function editsiswa($post)
// {
//     global $db;
//     $id = $post['id_siswa'];
//     $nama_siswa = $post['nama_siswa'];
//     $kelas = $post['kelas'];
//     $jurusan = $post['jurusan'];

//     // query untuk update
//     $query = "UPDATE tb_siswa SET nama_siswa = '$nama_siswa', kelas = '$kelas', jurusan = '$jurusan' WHERE id_siswa = $id";
//     mysqli_query($db, $query);
//     return mysqli_affected_rows($db);
// }

// // edit pembina
// function editguru($post)
// {
//     global $db;
//     $id = $post['id_pembina'];
//     $nama_pembina = $post['nama_pembina'];
//     $ekskul = $post['id_ekskul'];

//     // query untuk update
//     $query = "UPDATE tb_pembina SET nama_pembina = '$nama_pembina', id_ekskul = '$ekskul' WHERE id_pembina = $id";
//     mysqli_query($db, $query);
//     return mysqli_affected_rows($db);
// }

// // edit registrasi guru
// function edit_regisguru($post)
// {
//     global $db;
//     $id = $post['id_guru'];
//     $nama = $post['nama'];
//     $nip = $post['nip'];
//     $ekskul = $post['ekskul'];

//     // query untuk update
//     $query = "UPDATE register_guru SET nama_guru = '$nama', nip = '$nip', ekskul = '$ekskul' WHERE id_guru = $id";
//     mysqli_query($db, $query);
//     return mysqli_affected_rows($db);
// }

// // edit registrasi guru
// function edit_regissiswa($post)
// {
//     global $db;
//     $id = $post['id_siswa'];
//     $nama = $post['nama'];
//     $nisn = $post['nisn'];
//     $kelas = $post['kelas'];
//     $jurusan = $post['jurusan'];

//     // query untuk update
//     $query = "UPDATE register_siswa SET nama_siswa = '$nama', nisn = '$nisn', kelas = '$kelas', jurusan = '$jurusan' WHERE id_siswa = $id";
//     mysqli_query($db, $query);
//     return mysqli_affected_rows($db);
// }
