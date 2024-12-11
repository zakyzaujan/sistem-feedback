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
            $sql = "INSERT INTO user (nama_user, email_user, password_user, role_user, status_akun, tanggal_bergabung) 
                    VALUES ('$nama', '$email', '$password', 'pengguna','aktif',NOW())";
            if ($conn->query($sql)) {
                $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
                header('Location: login.php');
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
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background-image: url('assets/img/empty-elegant-background-with-copy-space.jpg');
        background-size: cover;
        background-position: center center;
        position: relative;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding-top: 62px;
        }

        .animation {
            animation: fadeIn 1.0s ease;
        }

        .card-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
        }

        .btn-custom {
            font-size: 1rem;
            text-transform: uppercase;
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            background-color: #0c3483 !important;
            border-color: #0c3483 !important;
            color: white;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            background-color: #a2b6df !important;
            border-color: #a2b6df !important;
        }

        @media (max-width: 768px) {
            .btn-custom {
                width: 100%;
                padding: 10px;
            }

            .card-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <img src="assets/icons/index_logo.png" alt="Logo Sistem Feedback" class="mb-4 " style="max-width: 120px;">
    <div class="card-container animation" style="width: 100%; max-width: 400px;">
        <h2 class="text-center text-dark mb-4"><i class="fa-solid fa-pen-to-square"></i> Register</h2>
        <p class="text-muted text-center">Pendaftaran akun khusus <b>pengguna.</b></p>
        <form method="POST" action="">
            <?php if (isset($error)) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="nama" class="form-label text-muted d-flex align-items-center">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label text-muted d-flex align-items-center">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-muted d-flex align-items-center">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="●●●●" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label text-muted d-flex align-items-center">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="●●●●" required>
            </div>
            <button type="submit" class="btn btn-custom w-100 mt-3">Daftar</button>
        </form>
        <p class="mt-3 text-center text-muted">Sudah punya akun? <a href="login.php">Login di sini</a>.</p>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>