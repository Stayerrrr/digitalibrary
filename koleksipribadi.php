<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil UserID dari sesi login
$userID = $_SESSION['UserID'];


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

// Query untuk mengambil data pengguna dari database
$username = $_SESSION['username'];
$sql_user = "SELECT * FROM user WHERE Username='$username'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
} else {
    echo "User not found.";
}

// Query untuk mengambil data judul dan ID buku dari database
$sql_buku = "SELECT p.BukuID, b.Judul
            FROM peminjaman p
            INNER JOIN buku b ON p.BukuID = b.BukuID
            WHERE p.UserID = '$userID'  AND p.StatusPeminjaman <> 'Sudah_Dikembalikan'";
$result_buku = $conn->query($sql_buku);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="koleksipribadi.css">
  <title>Dashboard</title>
</head>
<body>
  <div class="dashboard">
    <header>
      <h1>Koleksi Pribadi Kamu</h1>
    </header>
    <nav>
      <ul>
        <li><a href="menu.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <?php
            // Periksa apakah pengguna login dan memiliki peran Admin atau Petugas
            if(isset($_SESSION['Roles']) && ($_SESSION['Roles'] == 'Admin' || $_SESSION['Roles'] == 'petugas')) {
                // Jika ya, tampilkan tombol Pendataan Buku
                echo '<li><a href="pendataan.php">Pendataan Buku</a></li>';
            }
        ?>
        <?php
            // Periksa apakah pengguna login dan memiliki peran Admin atau Petugas
            if(isset($_SESSION['Roles']) && ($_SESSION['Roles'] == 'Peminjam')) {
                // Jika ya, tampilkan tombol Pendataan Buku
                echo '<li><a href="peminjaman.php">Peminjaman</a></li>';
            }
        ?>
        <?php
            // Periksa apakah pengguna login dan memiliki peran Admin atau Petugas
            if(isset($_SESSION['Roles']) && ($_SESSION['Roles'] == 'Peminjam')) {
                // Jika ya, tampilkan tombol Pendataan Buku
                echo '<li><a href="koleksipribadi.php">Koleksi Pribadi</a></li>';
            }
        ?>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <div class="main-content">
       <h2>Buku yang Dipinjam</h2>
       <?php
        if ($result_buku->num_rows > 0) {
         echo "<div class='content-container'>"; // Mulai div untuk kontainer buku
         while($row = $result_buku->fetch_assoc()) {
            echo "<div class='book'>"; // Buka div untuk setiap buku
            echo "<div class='content-text'>";
            echo "<h2>" . $row["Judul"] . "</h2>";
            echo "</div>";
            echo "<div class='image-container'>";
            echo "<a href='detail_buku.php?BukuID=" . $row["BukuID"] . "'>";
            echo "<img src='uploads/" . $row["Judul"] . ".jpg' alt=''>";
            echo "</a>";
            echo "</div>";
            echo "</div>"; // Tutup div untuk setiap buku
    }
    echo "</div>"; // Tutup div untuk kontainer buku
  } else {
    echo "Anda Belum Meminjam Buku";
  }
  ?>
    </div>
  </div>
</body>
</html>
