<?php
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

// Tangkap nilai yang dikirimkan melalui metode POST
$nama = $_POST['nama'];
$username = $_POST['username'];
$alamat = $_POST['alamat'];
$email = $_POST['Email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$roles = $_POST['role'];

// Periksa apakah password dan konfirmasi password cocok
if ($password != $confirm_password) {
    echo "Password dan confirm password tidak cocok.";
    exit();
}

// Periksa apakah nilai yang diterima adalah 'petugas' atau 'peminjam'
if ($roles != 'Peminjam') {
    echo "Peran tidak valid.";
    exit();
}

// Query untuk memeriksa apakah username sudah digunakan
$sql_check_username = "SELECT * FROM user WHERE Username='$username'";
$result_check_username = $conn->query($sql_check_username);

if ($result_check_username->num_rows > 0) {
    echo "Username sudah digunakan. Silakan coba dengan username lain.";
    exit();
}

// Query untuk menambahkan pengguna baru ke dalam database
$sql_insert_user = "INSERT INTO user (NamaLengkap, Username, Alamat, Email, Password) VALUES ('$nama', '$username', '$alamat', '$email', '$password', '$roles')";

if ($conn->query($sql_insert_user) === TRUE) {
    echo "Pendaftaran berhasil! Silakan login <a href='index.php'>di sini</a>.";
} else {
    echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
}

$conn->close();
?>
