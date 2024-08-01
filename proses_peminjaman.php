<?php
session_start(); // Mulai sesi untuk mengakses informasi pengguna yang sedang login

// Periksa apakah ada pengguna yang login
if(isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID']; // Ambil UserID dari sesi login
} else {
    // Tindakan yang akan diambil jika tidak ada pengguna yang login
    echo "Session UserID tidak tersedia. Silakan login terlebih dahulu.";
    exit; // Berhenti eksekusi skrip
}

// Tangkap data yang dikirimkan melalui metode POST
$judul_buku = $_POST['buku']; // Ubah menjadi judul buku terlebih dahulu
$tanggal_pinjam = $_POST['tanggal_pinjam'];
$tanggal_pengembalian = $_POST['tanggal_pengembalian'];

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

// Query untuk mendapatkan BukuID berdasarkan judul buku
$sql = "SELECT BukuID FROM buku WHERE Judul = '$judul_buku'";
$result = $conn->query($sql);

// Periksa hasil query
if ($result->num_rows > 0) {
    // Ambil BukuID dari hasil query
    $row = $result->fetch_assoc();
    $bukuID = $row['BukuID'];

    // Query untuk menyimpan data peminjaman ke dalam tabel peminjaman
    $sql = "INSERT INTO peminjaman (UserID, BukuID, TanggalPeminjaman, TanggalPengembalian, StatusPeminjaman) VALUES ('$userID', '$bukuID', '$tanggal_pinjam', '$tanggal_pengembalian', 'Dipinjam')";

    if ($conn->query($sql) === TRUE) {
        // Jika peminjaman berhasil disimpan
        // Redirect ke halaman menu.php dengan notifikasi peminjaman berhasil
        echo "<script>alert('Buku Berhasil Dipinjam!.'); window.location.href = 'koleksipribadi.php';</script>";
    } else {
        // Jika terjadi kesalahan dalam menyimpan data peminjaman
        echo "buku sudah Dipinjam atau buku tidak ada";
    }
} else {
    echo "Buku tidak ditemukan.";
}

// Tutup koneksi
$conn->close();
?>
