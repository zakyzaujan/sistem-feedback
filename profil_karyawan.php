<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user']; 

$sql_user = "SELECT nama_user, email_user FROM user WHERE id_user = '$id_user'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <link href="assets/css/pages/profil_karyawan.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="wrapper">
        <div class="side-wallpaper"></div>
        <div class="main-content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <a class="navbar-brand" href="dashboard_karyawan.php" id="judul"><i class="fa-solid fa-house"></i> Sistem Feedback | Karyawan</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item me-2">
                                <a class="nav-link" href="daftar_feedback.php"><i class="fa-regular fa-comment"></i> Antrian Feedback</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="feedback_diproses.php"><i class="fa-regular fa-folder"></i> Feedback Diproses</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="log_aktivitas.php"><i class="fa-regular fa-file"></i> Log Aktivitas</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="profil_karyawan.php"><i class="fa-solid fa-magnifying-glass"></i></i> | Info Profil</a></li>
                                    <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-power-off"></i> | Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container mt-5">
            <h3 class="mb-4 text-center"><i class="fa-regular fa-user"></i> Info Profil Karyawan</h3>
            <p class="text-muted text-center">Info mengenai akun karyawan sesuai dengan yang didaftarkan.</p>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card p-5">
                            <table class="table table-bordered mt-4">
                                <tr>
                                    <th>ID</th>
                                    <td><?= $id_user; ?></td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td><?= $user['nama_user']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $user['email_user']; ?></td>
                                </tr>
                            </table>
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