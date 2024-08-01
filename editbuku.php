<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "digitalibrary";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil parameter ID buku dari URL
$id_buku = isset($_GET['BukuID']) ? $_GET['BukuID'] : null;

if ($id_buku !== null && $id_buku !== '') {
    // Query untuk mendapatkan informasi buku berdasarkan ID
    $sql = "SELECT * FROM buku WHERE BukuID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_buku);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $buku = $result->fetch_assoc();
        // Tutup koneksi
        $stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="editbuku.css">
  <title>Edit Buku</title>
</head>
<body>
  <h2>Edit Buku</h2>
  <form action="proses_edit_buku.php" method="POST">
    <input type="hidden" name="bukuID" value="<?php echo $buku['BukuID']; ?>">
    <label for="judul">Judul:</label>
    <input type="text" id="judul" name="judul" value="<?php echo $buku['Judul']; ?>" required><br><br>
    <label for="penulis">Penulis:</label>
    <input type="text" id="penulis" name="penulis" value="<?php echo $buku['Penulis']; ?>" required><br><br>
    <label for="penerbit">Penerbit:</label>
    <input type="text" id="penerbit" name="penerbit" value="<?php echo $buku['Penerbit']; ?>" required><br><br>
    <label for="tahun">Tahun Terbit:</label>
    <input type="number" id="tahun" name="tahun" value="<?php echo $buku['TahunTerbit']; ?>" required><br><br>
    <input type="submit" value="Simpan Perubahan">
  </form>
</body>
</html>
<?php
    } else {
        echo "Buku tidak ditemukan.";
    }
} else {
    echo "ID buku tidak valid.";
}

// Tutup koneksi
$conn->close();
?>
