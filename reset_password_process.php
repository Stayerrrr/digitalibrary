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
    $email = $_POST['email'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];

    // Query untuk memeriksa kecocokan informasi identifikasi
    $sql = "SELECT * FROM user WHERE Username='$username' AND Email='$email' AND NamaLengkap='$nama_lengkap' AND Alamat='$alamat'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Informasi identifikasi cocok, tampilkan formulir untuk memasukkan password baru
        echo "<form method='post' action='reset_password_complete.php'>";
        echo "<input type='hidden' name='username' value='$username'>"; // Gunakan input hidden untuk menyimpan username
        echo "<label for='password_baru'>Password Baru:</label><br>";
        echo "<input type='password' id='password_baru' name='password_baru' required><br><br>";
        echo "<label for='konfirmasi'>Konfirmasi Password:</label><br>";
        echo "<input type='password' id='konfirmasi' name='konfirmasi' required><br><br>";
        echo "<input type='submit' value='Reset Password'>";
        echo "</form>";
    } else {
        // Informasi identifikasi tidak cocok
        echo "Informasi identifikasi tidak cocok. Silakan coba lagi.";
    }
}

$conn->close();
?>
