<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil data pengguna dari database
    $sql = "SELECT * FROM user WHERE Username=? AND Password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah pengguna ditemukan dalam database
    if ($result->num_rows > 0) {
        // Ambil baris data pengguna
        $row = $result->fetch_assoc();
        // Ambil UserID dari hasil query
        $userID = $row['UserID'];
        $roles = $row['Roles'];

        // Set session dengan nilai yang diperlukan
        $_SESSION['username'] = $username;
        $_SESSION['UserID'] = $userID;
        $_SESSION['Roles'] = $roles;

        // Redirect ke dashboard setelah login berhasil
        header("Location: menu.php");
        exit();
    } else {
        echo "<script>alert('Username atau Password salah!'); window.location.href = 'index.php';</script>";
        exit();
    }
}
?>
