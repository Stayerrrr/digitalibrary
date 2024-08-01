<?php
session_start();

// Hancurkan semua data sesi
session_destroy();

// Alihkan ke halaman login atau halaman lain setelah logout
header("Location: index.php");
exit();
?>
