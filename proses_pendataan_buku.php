<?php
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

// Tangkap data yang dikirimkan melalui formulir
$judul = $_POST['judul'];
$penulis = $_POST['penulis'];
$penerbit = $_POST['penerbit'];
$tahun = $_POST['tahun'];
$kategori = $_POST['kategori']; // Tangkap data kategori
$gambar = $_FILES['gambar']['name']; // Nama file gambar yang diunggah
$gambar_tmp = $_FILES['gambar']['tmp_name']; // Path sementara file gambar yang diunggah
$folder = "uploads/"; // Folder untuk menyimpan gambar

// Pindahkan gambar yang diunggah ke folder uploads
if (move_uploaded_file($gambar_tmp, $folder . $gambar)) {
    echo "Gambar berhasil diunggah.";
} else {
    echo "Gagal mengunggah gambar.";
}

// Query SQL untuk memasukkan data buku ke dalam tabel buku
$sql_buku = "INSERT INTO buku (Judul, Penulis, Penerbit, TahunTerbit) VALUES (?, ?, ?, ?)";
$stmt_buku = $conn->prepare($sql_buku);
$stmt_buku->bind_param("sssi", $judul, $penulis, $penerbit, $tahun);

// Query SQL untuk memasukkan data kategori ke dalam tabel kategoribuku
$sql_kategori = "INSERT INTO kategoribuku (NamaKategori) VALUES (?)";
$stmt_kategori = $conn->prepare($sql_kategori);
$stmt_kategori->bind_param("s", $kategori); // Bind parameter kategori

// Eksekusi kedua pernyataan SQL
if ($stmt_buku->execute() && $stmt_kategori->execute()) {
     echo "<script>alert('Data Buku Berhasil Ditambahkan!.'); window.location.href = 'menu.php';</script>";
} else {
    echo "Error: " . $sql_buku . "<br>" . $conn->error;
}

// Tutup koneksi
$stmt_buku->close();
$stmt_kategori->close();
$conn->close();
?>
