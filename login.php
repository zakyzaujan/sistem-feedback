<?php
session_start();
include 'config.php';

$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
unset($_SESSION['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_user = $_POST['nama_user'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE nama_user = '$nama_user' AND password_user = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['role_user'] = $user['role_user'];

        if ($user['role_user'] === 'pengguna') {
            header('Location: dashboard_user.php');
        } elseif ($user['role_user'] === 'karyawan') {
            header('Location: dashboard_karyawan.php');
        } elseif ($user['role_user'] === 'admin') {
            header('Location: dashboard_admin.php');
        }
        exit;
    } else {
        $error = "Nama atau password tidak sesuai!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Feedback</title>
    <link href="assets/css/pages/login.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4"><i class="fa-solid fa-right-to-bracket"></i> Login</h2>
        <p class="text-muted text-center">Gunakan akun yang sudah <b>terdaftar.</b></p>
        <form method="POST" action="">
            <!-- Alert Sukses -->
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($success); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- Alert Gagal -->
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="nama_user" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Masukkan Nama" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="●●●●" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="mt-3 text-center">Belum punya akun? <a href="register.php" class="text-primary">Daftar di sini</a></p>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>