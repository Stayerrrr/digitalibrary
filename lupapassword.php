<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Password</title>
<link rel="stylesheet" href="lupapassword.css"> <!-- Memuat file CSS terpisah -->
</head>
<body>
<h2>Lupa Password</h2>
<form method="post" action="reset_password_process.php">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="nama_lengkap">Nama Lengkap:</label><br>
    <input type="text" id="nama_lengkap" name="nama_lengkap" required><br><br>

    <label for="alamat">Alamat:</label><br>
    <textarea id="alamat" name="alamat" required></textarea><br><br>

    <input type="submit" value="Reset Password">
</form>
</body>
</html>
