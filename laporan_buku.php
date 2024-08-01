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

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="laporan_user.css">
  <title>Dashboard</title>
</head>
<body>
  <div class="dashboard">
    <header>
      <h1>Laporan Buku</h1>
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
              echo '<li><a href="pendataan.php">Pendataan Buku</a></li>';
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
    <div class="table-container">
        <h2>Data Buku</h2>
        <?php
        // Query untuk mengambil data buku dari tabel buku
        $sql_laporan_buku = "SELECT * FROM buku";
        $result_laporan_buku = $conn->query($sql_laporan_buku);

        if ($result_laporan_buku->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun Terbit</th><th>Edit</th></tr>";
            while($row = $result_laporan_buku->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["BukuID"] . "</td>";
                echo "<td>" . $row["Judul"] . "</td>";
                echo "<td>" . $row["Penulis"] . "</td>";
                echo "<td>" . $row["Penerbit"] . "</td>";
                echo "<td>" . $row["TahunTerbit"] . "</td>";
                echo "<td><a href='editbuku.php?BukuID=" . $row["BukuID"] . "'>Edit</a> | <a href='hapus_buku.php?BukuID=" . $row["BukuID"] . "'>Hapus</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Tidak ada data buku.";
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
