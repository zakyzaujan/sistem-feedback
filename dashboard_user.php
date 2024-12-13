<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'pengguna') {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user'];

$sql_user = "SELECT nama_user FROM user WHERE id_user = '$id_user'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
$nama_user = $user['nama_user'];

$query_pending_feedback = "SELECT COUNT(*) AS pending FROM feedback WHERE id_user = '$id_user' AND status = 'Pending'";
$result_pending_feedback = $conn->query($query_pending_feedback);
$pending_feedback = $result_pending_feedback->fetch_assoc()['pending'];

$query_feedback_diproses = "SELECT COUNT(*) AS diproses FROM feedback WHERE id_user = '$id_user' AND status = 'Diproses'";
$result_feedback_diproses = $conn->query($query_feedback_diproses);
$feedback_diproses = $result_feedback_diproses->fetch_assoc()['diproses'];

$query_feedback_selesai = "SELECT COUNT(*) AS selesai FROM feedback WHERE id_user = '$id_user' AND status = 'Selesai'";
$result_feedback_selesai = $conn->query($query_feedback_selesai);
$feedback_selesai = $result_feedback_selesai->fetch_assoc()['selesai'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - Sistem Feedback | Pengguna</title>
    <link href="assets/css/pages/dashboard_user.css" rel="stylesheet">
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

        .animation{
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
                    <a class="navbar-brand fw-bold" href="dashboard_user.php" id="judul"><i class="fa-solid fa-house"></i> Sistem Feedback | <?=$nama_user;?></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item me-2">
                                <a class="nav-link" href="kirim_feedback.php"><i class="fa-regular fa-comment"></i> Kirim Feedback</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="feedback_saya.php"><i class="fa-regular fa-folder"></i> Feedback Saya</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="profil_user.php"><i class="fa-solid fa-magnifying-glass"></i></i> | Info Profil</a></li>
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
                    <p class="mt-3 fs-5">Pantau feedback Anda dengan mudah dan efisien.</p>
                </div>
            </div>

            <div class="container mt-5 mt-lg-7">
                <h4 class="mb-4 text-center"><i class="fa-solid fa-chart-simple"></i> Statistik Feedback Anda</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Pending Feedback</h5>
                                <p class="card-text fs-4"><b><?= $pending_feedback ?></b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Feedback Dalam Proses</h5>
                                <p class="card-text fs-4"><b><?= $feedback_diproses ?></b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body text-center">
                                <h5 class="card-title">Feedback Selesai</h5>
                                <p class="card-text fs-4"><b><?= $feedback_selesai ?></b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div class="row justify-content-center text-center">
                    <div class="col-md-4">
                        <div class="info-card p-4 bg-light">
                            <img src="assets/icons/feedback.png" alt="Kirim Feedback">
                            <h5 class="mt-3">Kirim Feedback</h5>
                            <p>Kirim masukan dan saran untuk sistem.</p>
                            <a href="kirim_feedback.php" class="btn btn-primary">Kirim Feedback</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card p-4 bg-light">
                            <img src="assets/icons/daftar_feedback.png" alt="Feedback Saya">
                            <h5 class="mt-3">Feedback Saya</h5>
                            <p>Lihat dan pantau status feedback Anda.</p>
                            <a href="feedback_saya.php" class="btn btn-primary">Lihat Feedback</a>
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
