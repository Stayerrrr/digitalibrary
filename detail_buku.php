<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Buku</title>
  <link rel="stylesheet" href="detail_buku.css"> <!-- Sisipkan file CSS -->
</head>
<body>
  <div class="container">
  <?php
  // Mulai sesi
  session_start();

  // Koneksi ke database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "digitalibrary";
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Periksa koneksi
  if ($conn->connect_error) {
      die("Koneksi gagal: " . $conn->connect_error);
  }
  
  // Ambil parameter ID buku dari URL
  $id_buku = $_GET['BukuID'];
  
  // Query untuk mendapatkan informasi buku berdasarkan ID
  $sql = "SELECT * FROM buku WHERE BukuID = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_buku);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
      $buku = $result->fetch_assoc();
      // Tampilkan informasi buku
      echo "<h2 style='text-align: center;'>" . $buku['Judul'] . "</h2>";
      echo "<div class='book-info'>";
      echo "<p>Penulis: " . $buku['Penulis'] . "</p>";
      echo "<p>Penerbit: " . $buku['Penerbit'] . "</p>";
      echo "<p>Tahun Terbit: " . $buku['TahunTerbit'] . "</p>";
      echo "</div>";
  
      // Tampilkan gambar buku
      $gambar_path = "uploads/" . $buku['Judul'] . ".jpg";
      echo "<div class='book-image-container'>";
      echo "<img class='book-image' src='" . $gambar_path . "' alt='Gambar Buku'>";

      // Ambil UserID dari session
      $userID = $_SESSION['UserID'];

      //Menampilkan Tombol khusus Peminjam
      if(isset($_SESSION['Roles']) && $_SESSION['Roles'] == 'Peminjam') {      
          echo "<div class='book-buttons'>";
          echo "<form action='peminjaman.php' method='GET'>";
          echo "<input type='hidden' name='BukuID' value='" . $id_buku . "'>";
          echo "<input type='submit' value='Pinjam'>";
          echo "</form>";
         
          echo "<form action='kembali.php' method='POST'>";
          echo "<input type='hidden' name='BukuID' value='" . $id_buku . "'>";
          echo "<input type='submit' value='Kembali'>";
          echo "</form>";
          echo "</div>";
      }

      //Menampilkan tombol khusus Admin
      if(isset($_SESSION['Roles']) && ($_SESSION['Roles'] == 'Admin' || $_SESSION['Roles'] == 'petugas')) {      
        echo "<div class='book-buttons'>";
        echo "<form action='hapus_buku.php' method='POST'>";
        echo "<input type='hidden' name='BukuID' value='" . $id_buku . "'>";
        echo "<input type='submit' value='Hapus'>";
        echo "</form>";

        echo "<form action='editbuku.php' method='GET'>";
        echo "<input type='hidden' name='BukuID' value='" . $id_buku . "'>";
        echo "<input type='submit' value='Edit'>";
        echo "</form>";

        echo "</div>";
    }
      echo "</div>"; // Penutup div.book-image-container
  }
  
  // Tutup koneksi
  $stmt->close();
  $conn->close();
  ?>
  </div>
</body>
</html>
