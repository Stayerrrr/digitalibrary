<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['UserID'])) {
    // Koneksi ke database
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "digitalibrary";

    // Buat koneksi
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Tangkap nilai UserID yang dikirimkan melalui parameter GET
    $userID = $_GET['UserID'];

    // Query untuk menghapus pengguna berdasarkan UserID
    $sql = "DELETE FROM user WHERE UserID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();

    // Redirect kembali ke halaman laporan setelah penghapusan berhasil
    header("Location: laporan_user.php");
    exit();
} else {
    // Jika parameter UserID tidak diberikan atau metode request bukan GET, kembali ke halaman sebelumnya atau lakukan penanganan lainnya
    // Misalnya, arahkan kembali ke halaman laporan dengan pesan kesalahan
    header("Location: laporan_user.php?error=1");
    exit();
}
?>
