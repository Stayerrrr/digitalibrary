<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
$sql_buku = "SELECT BukuID, Judul FROM buku";
$result_buku = $conn->query($sql_buku);

$peminjamanID = isset($_GET['PeminjamanID']) ? $_GET['PeminjamanID'] : null;

// Sekarang Anda dapat menggunakan $peminjamanID dengan aman

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="dashboard.css">
  <title>Dashboard</title>
</head>
<body>
  <div class="dashboard">
    <header>
      <h1>Welcome, <?php echo $user['NamaLengkap']; ?>!</h1>
    </header>
    <nav>
      <ul>
        <li><a href="menu.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <?php
            // Periksa apakah pengguna login dan memiliki peran Admin atau Petugas
            if(isset($_SESSION['Roles']) && ($_SESSION['Roles'] == 'Admin')) {
                // Jika ya, tampilkan tombol Pendataan Buku
                echo '<li><a href="pendataan.php">Pendataan Buku</a></li>';
                echo '<li><a href="laporan_user.php">Laporan User</a></li>';
                echo '<li><a href="laporan_buku.php">Laporan Buku</a></li>';
            }
        ?>
        <?php
            // Periksa apakah pengguna login dan memiliki peran Admin atau Petugas
            if(isset($_SESSION['Roles']) && ($_SESSION['Roles'] == 'petugas')) {
                // Jika ya, tampilkan tombol Pendataan Buku
                echo '<li><a href="laporan_buku.php">Laporan Buku</a></li>';
            }
        ?>
        <?php
            // Periksa apakah pengguna login dan memiliki peran Admin atau Petugas
            if(isset($_SESSION['Roles']) && ($_SESSION['Roles'] == 'Peminjam')) {
                // Jika ya, tampilkan tombol Pendataan Buku
                echo '<li><a href="koleksipribadi.php">Koleksi Pribadi</a></li>';
                echo '<li><a href="peminjaman.php">Peminjaman</a></li>';
            }
        ?>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
    <div class="main-content">
      <h2>Trending</h2>
      <?php
      if ($result_buku->num_rows > 0) {
        echo "<div class='content-container'>"; // Mulai div untuk kontainer buku
        while($row = $result_buku->fetch_assoc()) {
            echo "<div class='book'>"; // Buka div untuk setiap buku
            echo "<div class='content-text'>";
            echo "<h2>" . $row["Judul"] . "</h2>";
            
            // Tampilkan gambar buku tanpa tautan
            echo "<div class='image-container'>";
            echo "<img src='uploads/" . $row["Judul"] . ".jpg' alt=''>";
            echo "</div>";

            // Tambahkan tombol detail di bawah judul
            echo "<a href='detail_buku.php?BukuID=" . $row["BukuID"] . "' class='detail-button'>Detail</a>";
            echo "</div>"; // Tutup div content-text
            
            echo "</div>"; // Tutup div untuk setiap buku
        }
        echo "</div>"; // Tutup div untuk kontainer buku
    } else {
        echo "Tidak ada data buku";
    }
    ?>
  </div>

</div>
</body>
</html>
