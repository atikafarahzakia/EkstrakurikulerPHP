<?php
include 'connect.php';

// delete siswa
function deletesiswa($id)
{
    global $db;
    // query hapus data
    $query = "DELETE FROM tb_siswa WHERE id_siswa = $id";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// delete guru
function deleteguru($id_pembina)
{
    global $db;
    $id_pembina = (int)$id_pembina;

    // Hapus relasi dulu
    mysqli_query($db, "DELETE FROM tb_ekskul_pembina WHERE id_pembina = $id_pembina");

    // Hapus tb_pembina (jika ada)
    mysqli_query($db, "DELETE FROM tb_pembina WHERE id_pembina = $id_pembina");


    return mysqli_affected_rows($db);
}

// delete ekskul
function deleteekskul($id)
{
    global $db;
    // query hapus data
    $query = "DELETE FROM tb_ekskul WHERE id_ekskul = $id";
    mysqli_query($db, "DELETE FROM tb_jadwal WHERE id_ekskul = $id");
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// delete data regis guru
function hapus_regisguru($id)
{
    global $db;
    // query hapus data
    $query = "DELETE FROM register_guru WHERE id_guru = $id";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// delete regis siswa
function hapus_regissiswa($id)
{
    global $db;
    // query hapus data
    $query = "DELETE FROM register_siswa WHERE id_siswa = $id";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
