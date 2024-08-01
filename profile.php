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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="profile.css">
  <title>Dashboard</title>
</head>
<body>
  <div class="dashboard">
    <header>
      <h1>Profil Pribadi Kamu</h1>
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
            if(isset($_SESSION['Roles']) && ($_SESSION['Roles'] == 'petugas')) {
              // Jika ya, tampilkan tombol Pendataan Buku
              echo '<li><a href="laporan_buku.php">Laporan Buku</a></li>';
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
        <h3>Informasi Pribadi</h3>
        <p> Nama Lengkap:<?php echo $user['NamaLengkap'];?></p>
        <p>Username: <?php echo $user['Username'];?></p>
        <p>Alamat: <?php echo $user['Alamat'];?></p>
        <p>Email: <?php echo $user['Email'];?></p><br>
    </div>

  </div>
</body>
</html>
