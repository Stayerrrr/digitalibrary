<?php
session_start();

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

$userID = $_GET['id'];

// Query untuk mengambil data pengguna berdasarkan ID
$sql_user = "SELECT * FROM user WHERE UserID='$userID'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows == 1) {
    $user = $result_user->fetch_assoc();
} else {
    echo "User not found.";
}

// Proses form jika ada pengiriman data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaLengkap = $_POST['namaLengkap'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    // Query untuk mengupdate data pengguna
    $sql_update = "UPDATE user SET NamaLengkap='$namaLengkap', Username='$username', Email='$email', Alamat='$alamat' WHERE UserID='$userID'";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('User Berhasil Diupdate!.'); window.location.href = 'laporan_user.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
  <link rel="stylesheet" href="edit_user.css"> <!-- Ganti dengan lokasi CSS Anda -->
</head>
<body>
  <div class="form-container">
    <h2>Edit User</h2>
    <form method="post">
      <div class="form-group">
        <label for="namaLengkap">Nama Lengkap:</label>
        <input type="text" id="namaLengkap" name="namaLengkap" value="<?php echo $user['NamaLengkap']; ?>">
      </div>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['Username']; ?>">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['Email']; ?>">
      </div>
      <div class="form-group">
        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat"><?php echo $user['Alamat']; ?></textarea>
      </div>
      <div class="form-group">
        <input type="submit" value="Update">
      </div>
    </form>
  </div>
</body>

<script>
    // Fungsi untuk memeriksa format email
    function validateEmail(email) {
        const re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    // Fungsi untuk menampilkan pesan error jika format email tidak valid
    function checkEmail() {
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('email-error');
        const email = emailInput.value.trim();
        
        if (!validateEmail(email)) {
            emailError.textContent = 'Format email tidak valid';
            emailInput.focus();
            return false;
        } else {
            emailError.textContent = '';
            return true;
        }
    }

    // Event listener untuk memanggil fungsi checkEmail saat input kehilangan fokus
    document.getElementById('email').addEventListener('blur', checkEmail);
</script>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
