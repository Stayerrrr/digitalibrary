<?php
// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['UserID'])) {
    // Jika tidak, alihkan ke halaman login atau tampilkan pesan kesalahan
    echo "Silakan login terlebih dahulu.";
    exit(); // Hentikan eksekusi skrip
}

// Periksa apakah PeminjamanID terdefinisi
if (!isset($_GET['PeminjamanID'])) {
    echo "PeminjamanID tidak valid.";
    exit();
}

// Tangkap PeminjamanID dari URL atau formulir
$peminjamanID = $_GET['PeminjamanID']; // Anda mungkin perlu menyesuaikan ini tergantung pada bagaimana Anda mengirimkan PeminjamanID

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "digitalibrary";
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Persiapkan kueri SQL dengan parameter terikat
$sql = "UPDATE peminjaman SET StatusPeminjaman = 'Sudah_Dikembalikan' WHERE PeminjamanID = ? AND UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $peminjamanID, $_SESSION['UserID']);

// Eksekusi kueri
if ($stmt->execute()) {
    // Jika berhasil mengubah StatusPeminjaman
    echo "Buku berhasil dikembalikan.";
} else {
    // Jika terjadi kesalahan
    echo "Error: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
