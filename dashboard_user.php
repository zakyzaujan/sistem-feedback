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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            border-bottom: 2px solid #dee2e6;
        }
        .dashboard-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .info-card {
            border-left: 4px solid #0d6efd;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .info-card h4 {
            margin-bottom: 0;
            color: #0d6efd;
        }
        .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: white !important;
        }

        .btn-danger:hover {
            background-color: darkred !important;
            border-color: darkred !important;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Sistem Feedback | Pengguna</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="kirim_feedback.php">Kirim Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="feedback_saya.php">Feedback Saya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil_saya.php">Info Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="dashboard-container">
            <h2 class="text-center mb-4">Selamat Datang, <b><?= $nama_user ?></b></h2>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="info-card">
                        <h4>Total Feedback Dikirim</h4>
                        <p class="mb-0 fs-5">
                            <?php
                            $sql_total_feedback = "SELECT COUNT(*) as total FROM feedback WHERE id_user = '$id_user'";
                            $result_total_feedback = $conn->query($sql_total_feedback);
                            $total_feedback = $result_total_feedback->fetch_assoc()['total'];
                            echo $total_feedback;
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <h4>Feedback Dalam Proses</h4>
                        <p class="mb-0 fs-5">
                            <?php
                            $sql_feedback_proses = "SELECT COUNT(*) as total FROM feedback WHERE id_user = '$id_user' AND status = 'Dalam Proses'";
                            $result_feedback_proses = $conn->query($sql_feedback_proses);
                            $feedback_proses = $result_feedback_proses->fetch_assoc()['total'];
                            echo $feedback_proses;
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <h4>Feedback Selesai</h4>
                        <p class="mb-0 fs-5">
                            <?php
                            $sql_feedback_selesai = "SELECT COUNT(*) as total FROM feedback WHERE id_user = '$id_user' AND status = 'Selesai'";
                            $result_feedback_selesai = $conn->query($sql_feedback_selesai);
                            $feedback_selesai = $result_feedback_selesai->fetch_assoc()['total'];
                            echo $feedback_selesai;
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="kirim_feedback.php" class="btn btn-primary btn-lg me-2">Kirim Feedback</a>
                <a href="feedback_saya.php" class="btn btn-outline-primary btn-lg">Lihat Feedback Saya</a>
            </div>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
