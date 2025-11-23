<?php
session_start();
session_unset(); // hapus semua session
session_destroy(); // destroy session

echo "<script>alert('Berhasil Logout!'); window.location='login_siswa.php';</script>";
exit();
