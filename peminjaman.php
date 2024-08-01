<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peminjaman Buku</title>
<link rel="stylesheet" href="peminjaman.css">
</head>
<body>
<header>
      <h1>Jangan Lupa Kembalikan Ya!</h1>
</header>
<h2>Peminjaman Buku</h2>
<form action="proses_peminjaman.php" method="POST">
    <label for="buku">Buku yang Dipinjam:</label><br>
    <select id="buku" name="buku" onchange="showBookImage()" required>
        <?php
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

        // Query untuk mendapatkan daftar buku yang tersedia
        $sql = "SELECT BukuID, Judul FROM buku";
        $result = $conn->query($sql);

        // Periksa hasil query
        if ($result->num_rows > 0) {
            // Output data dari setiap baris
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['Judul'] . "'>" . $row['Judul'] . "</option>";
            }
        } else {
            echo "<option value=''>Tidak ada buku tersedia</option>";
        }

        // Tutup koneksi
        $conn->close();
        ?>
    </select><br><br>
    
    <label for="tanggal_pinjam">Tanggal Pinjam:</label><br>
    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" required>
    <label for="tanggal_pinjam">Tanggal Pengembalian:</label><br>
    <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian" required><br><br>
    
    <input type="submit" value="Pinjam Buku">

    <script>
    // Mendapatkan elemen input untuk tanggal peminjaman dan tanggal pengembalian
    var tanggalPinjamInput = document.getElementById("tanggal_pinjam");
    var tanggalPengembalianInput = document.getElementById("tanggal_pengembalian");
    
    // Mendapatkan tanggal saat ini
    var currentDate = new Date();
    
    // Menetapkan tanggal peminjaman sebagai tanggal saat ini
    tanggalPinjamInput.value = currentDate.toISOString().slice(0,10);
    
    // Mendapatkan tanggal dua minggu ke depan
    var duaMingguKedepan = new Date(currentDate.getTime() + (14 * 24 * 60 * 60 * 1000));
    
    // Menetapkan tanggal pengembalian sebagai dua minggu ke depan
    tanggalPengembalianInput.value = duaMingguKedepan.toISOString().slice(0,10);
    </script>
</form>
</body>
</html>
