<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data admin
$sql_user = "SELECT nama_user FROM user WHERE id_user = '$id_user'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
$nama_user = $user['nama_user'];

// Ambil data statistik
$query_total_users = "SELECT COUNT(*) AS total_users FROM user";
$result_total_users = $conn->query($query_total_users);
$total_users = $result_total_users->fetch_assoc()['total_users'];

$query_total_feedback = "SELECT COUNT(*) AS total_feedback FROM feedback";
$result_total_feedback = $conn->query($query_total_feedback);
$total_feedback = $result_total_feedback->fetch_assoc()['total_feedback'];

$query_feedback_selesai = "SELECT COUNT(*) AS selesai FROM feedback WHERE status = 'selesai'";
$result_feedback_selesai = $conn->query($query_feedback_selesai);
$feedback_selesai = $result_feedback_selesai->fetch_assoc()['selesai'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Feedback</title>
    <link href="assets/css/pages/dashboard_admin.css" rel="stylesheet">
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

        .animation {
            animation: fadeIn 0.3s ease;
        }
    </style>
</head>
<body class="bg-light">
    <div class="wrapper">
        <div class="side-wallpaper"></div>
        <div class="main-content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <a class="navbar-brand fw-bold" href="dashboard_admin.php"><i class="fa-solid fa-house"></i> Sistem Feedback | Admin</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item me-2">
                                <a class="nav-link" href="manage_users.php"><i class="fa-regular fa-user"></i> Manajemen Pengguna</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="feedback_list.php"><i class="fa-regular fa-comment"></i> Daftar Feedback</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="settings.php"><i class="fa-solid fa-cog"></i> Pengaturan</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="profil_admin.php"><i class="fa-solid fa-user"></i> | Profil</a></li>
                                    <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-power-off"></i> | Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="animation">
                <div class="container mt-5">
                    <div class="hero-section text-white text-center">
                        <h2>Selamat Datang, <b><?= $nama_user ?></b></h2>
                        <p class="mt-3 fs-5">Kelola sistem feedback dan pengguna dengan mudah.</p>
                    </div>
                </div>

                <div class="container mt-5">
                    <h4 class="mb-4 text-center"><i class="fa-solid fa-chart-simple"></i> Statistik Sistem</h4>
                    <div class="row justify-content-center">
                        <!-- Jumlah Pengguna -->
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Jumlah Pengguna</h5>
                                    <p class="card-text fs-4"><b><?= $total_users ?></b></p>
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah Feedback -->
                        <div class="col-md-4">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Jumlah Feedback</h5>
                                    <p class="card-text fs-4"><b><?= $total_feedback ?></b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="info-card p-4 bg-light">
                                <img src="assets/icons/users.png" alt="Manajemen Pengguna">
                                <h5 class="mt-3">Manajemen Pengguna</h5>
                                <p>Kelola semua data pengguna sistem.</p>
                                <a href="manage_users.php" class="btn btn-primary">Lihat</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-4 bg-light">
                                <img src="assets/icons/feedback.png" alt="Daftar Feedback">
                                <h5 class="mt-3">Daftar Feedback</h5>
                                <p>Kelola semua feedback yang masuk.</p>
                                <a href="feedback_list.php" class="btn btn-primary">Lihat</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card p-4 bg-light">
                                <img src="assets/icons/settings.png" alt="Pengaturan">
                                <h5 class="mt-3">Pengaturan</h5>
                                <p>Kelola pengaturan sistem.</p>
                                <a href="settings.php" class="btn btn-primary">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="side-wallpaper"></div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>
