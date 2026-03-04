<?php
session_start();

// Hapus semua data session
session_unset();
session_destroy();

// Hapus cookie username dan key jika ada
setcookie('username', '', time() - 3600, "/");
setcookie('key', '', time() - 3600, "/");

// Redirect kembali ke halaman utama
header("Location: ../index.php");
exit;
?>