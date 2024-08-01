<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pendataan Buku</title>
  <link rel="stylesheet" href="pendataan.css">
</head>
<body>

  <h2>Form Pendataan Buku</h2>

  <form action="proses_pendataan_buku.php" method="post" enctype="multipart/form-data">
    <label for="judul">Judul Buku:</label>
    <input type="text" id="judul" name="judul" required>

    <label for="penulis">Penulis:</label>
    <input type="text" id="penulis" name="penulis" required>

    <label for="penulis">Penerbit:</label>
    <input type="text" id="penerbit" name="penerbit" required>

    <label for="tahun">Tahun Terbit:</label>
    <input type="number" id="tahun" name="tahun" required>

    <label for="kategori">Kategori:</label><br>
    <select id="kategori" name="kategori" required>
    <option value="Fiksi">Fiksi</option>
    <option value="Non-Fiksi">Non-Fiksi</option>
    <option value="Komik">Komik</option>
    <!-- Tambahkan pilihan kategori lainnya di sini sesuai kebutuhan -->
    </select><br><br>

    <label for="gambar">Gambar Buku:</label>
    <input type="file" id="gambar" name="gambar" accept="image/*" required>

    <input type="submit" value="Simpan">
  </form><br><br>

  <form id="tambahKategoriForm">
    <label for="kategoriBaru">Tambah Kategori Baru:</label>
    <input type="text" id="kategoriBaru" name="kategoriBaru">
    <button type="button" onclick="tambahKategori()">Tambah</button>
</form>

</body>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Memeriksa apakah terdapat kategori yang tersimpan di localStorage
    if(localStorage.getItem("kategori")) {
        // Mengambil kategori dari localStorage
        var savedKategori = JSON.parse(localStorage.getItem("kategori"));
        
        // Memperbarui dropdown kategori dengan kategori yang tersimpan
        var select = document.getElementById("kategori");
        savedKategori.forEach(function(item) {
            var option = document.createElement("option");
            option.text = item;
            option.value = item;
            select.add(option);
        });
    }
});

function tambahKategori() {
    var kategoriBaru = document.getElementById("kategoriBaru").value;
    var select = document.getElementById("kategori");
    var option = document.createElement("option");
    option.text = kategoriBaru;
    option.value = kategoriBaru;
    select.add(option);

    // Menyimpan pilihan kategori ke localStorage
    var savedKategori = localStorage.getItem("kategori") ? JSON.parse(localStorage.getItem("kategori")) : [];
    savedKategori.push(kategoriBaru);
    localStorage.setItem("kategori", JSON.stringify(savedKategori));
}
</script>
</html>
