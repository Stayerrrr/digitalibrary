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
      <h1>Laporan User</h1>
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
        <h2>Data Pengguna</h2>
        <?php
        // Query untuk mengambil data pengguna dari tabel user
        $sql_laporan_user = "SELECT * FROM user";
        $result_laporan_user = $conn->query($sql_laporan_user);

        if ($result_laporan_user->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nama Lengkap</th><th>Username</th><th>Password</th><th>Email</th><th>Alamat</th><th>Edit</th></tr>";
            while($row = $result_laporan_user->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["UserID"] . "</td>";
                echo "<td>" . $row["NamaLengkap"] . "</td>";
                echo "<td>" . $row["Username"] . "</td>";
                echo "<td>" . $row["Password"] . "</td>";
                echo "<td>" . $row["Email"] . "</td>";
                echo "<td>" . $row["Alamat"] . "</td>";
                echo "<td><a href='edit_user.php?id=" . $row["UserID"] . "'>Edit</a> | <a href='hapus_user.php?UserID=" . $row["UserID"] . "'>Hapus</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Tidak ada data pengguna.";
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>

