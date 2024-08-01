<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah pengguna memiliki akses admin
    if ($_SESSION['Roles'] != 'Admin') {
        echo "Anda tidak memiliki akses untuk menghapus buku.";
        exit();
    }

    // Koneksi ke database
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "digitalibrary";
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Tangkap nilai ID buku yang akan dihapus
    $id_buku = $_POST['BukuID'];

    // Query untuk menghapus buku dari database
    $sql = "DELETE FROM buku WHERE BukuID = $id_buku";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Buku berhasil dihapus.'); window.location.href = 'menu.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
}
?>
