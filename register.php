<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $sql_check = "SELECT * FROM user WHERE nama_user = '$nama' OR email_user = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $error = "Nama atau email sudah terdaftar!";
    } else {
        if ($password !== $confirm_password) {
            $error = "Password dan Konfirmasi Password tidak sama!";
        } else {
            $sql = "INSERT INTO user (nama_user, email_user, password_user, role_user) 
                    VALUES ('$nama', '$email', '$password', 'pengguna')";
            if ($conn->query($sql)) {
                $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
                header('Location: index.php');
                exit;
            } else {
                $error = "Registrasi gagal!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Feedback</title>
    <link href="assets/css/pages/register.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4"><i class="fa-solid fa-pen-to-square"></i> Register</h2>
        <p class="text-muted text-center">Pendaftaran akun khusus <b>pengguna.</b></p>
        <form method="POST" action="">
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="●●●●" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="●●●●" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <p class="mt-3 text-center">Sudah punya akun? <a href="index.php">Login di sini</a></p>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>