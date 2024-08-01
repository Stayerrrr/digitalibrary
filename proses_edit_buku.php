<?php
// Memulai sesi
session_start();

// Memeriksa apakah pengguna telah login dan memiliki akses sebagai admin
if (!isset($_SESSION['Roles']) || $_SESSION['Roles'] !== 'Admin') {
    // Jika tidak, redirect ke halaman login atau halaman lain yang sesuai
    header("Location: login.php");
    exit(); // Menghentikan eksekusi skrip
}

// Memeriksa apakah metode HTTP yang digunakan adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "digitalibrary";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Tangkap data yang dikirimkan melalui formulir
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $bukuID = $_POST['bukuID']; // Tambahkan penangkapan BukuID

    // Query SQL untuk memperbarui data buku berdasarkan judul
    $sql = "UPDATE buku SET Judul=?, Penulis=?, Penerbit=?, TahunTerbit=? WHERE BukuID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $judul, $penulis, $penerbit, $tahun, $bukuID); // Ubah binding parameter

    // Eksekusi pernyataan SQL
    if ($stmt->execute()) {
        echo "Data buku berhasil diperbarui.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $stmt->close();
    $conn->close();
}
?>
