<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi'];

    // Periksa apakah password baru dan konfirmasi password sama
    if ($password_baru === $konfirmasi) {
        // Query untuk mengupdate password baru ke dalam database
        $sql = "UPDATE user SET Password='$password_baru' WHERE Username='$username'";
        $result = $conn->query($sql);

        if ($result) {
            // Password berhasil direset
            echo "<script>
                    alert('Password berhasil direset.');
                    window.location.href = 'index.php'; // Redirect ke halaman index.php
                  </script>";
        } else {
            // Terjadi kesalahan dalam mengupdate password
            echo "Gagal mereset password. Silakan coba lagi.";
        }
    } else {
        // Jika password baru dan konfirmasi tidak sama
        echo "<script>
                alert('Password baru dan konfirmasi password tidak cocok.');
                window.location.href = 'lupapassword.php'; // Redirect kembali ke form reset password
              </script>";
    }
}

$conn->close();
?>
