<?php
session_start();        // Memulai session agar bisa mengakses data session yang aktif
session_unset();        // Menghapus semua variabel session yang sedang disimpan
session_destroy();      // Menghancurkan session pada server sehingga semua data session benar-benar hilang

// Script JavaScript untuk menampilkan alert dan redirect ke halaman login
echo "<script>alert('Berhasil Logout!');window.location='login_siswa.php';</script>";
exit();                 // Menghentikan proses script agar tidak ada kode lain dieksekusi
