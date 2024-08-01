<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="registerstyle.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="registeraction.php" method="post">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" required>
            <label for="nik">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" required>
            <label for="jenis_kelamin">Email:</label>
            <input type="text" id="Email" name="Email" required>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            <label for="role">Roles:</label>
            <select id="role" name="role">
                <option value="Peminjam">Peminjam</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <br>
        <a href="index.php">Sudah punya akun?</a>
    </div>
</body>
</html>
