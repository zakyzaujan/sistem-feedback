<?php
session_start();
include 'config.php';

$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
unset($_SESSION['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_user = $_POST['nama_user'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE nama_user = ? AND password_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nama_user, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['status_akun'] === 'aktif') {
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
            $error = "Maaf, akun Anda sudah tidak aktif!";
        }
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
        padding-bottom: 110px;
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
        <h2 class="text-center text-dark mb-4"><i class="fa-solid fa-right-to-bracket"></i> Login</h2>
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
                <?php unset($error); ?>
            <?php endif; ?>
            <div class="mb-3">
                <label for="nama_user" class="form-label text-muted d-flex align-items-center">Nama</label>
                <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Masukkan Nama" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label text-muted d-flex align-items-center">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="●●●●" required>
            </div>
            <button type="submit" class="btn btn-custom w-100 mt-3">Masuk</button>
        </form>
        <p class="mt-3 text-center text-muted">Belum punya akun? <a href="register.php" class="text-primary">Daftar di sini</a>.</p>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>