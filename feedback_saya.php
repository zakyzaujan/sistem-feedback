<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'pengguna') {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user']; 

$sql_feedback_user = "SELECT feedback.*, kategori_feedback.nama_kategori, 
                             log_aktivitas.balasan,
                             log_aktivitas.tanggal_balasan, 
                             karyawan.nama_user AS nama_karyawan
                      FROM feedback
                      LEFT JOIN kategori_feedback ON feedback.id_kategori = kategori_feedback.id_kategori
                      LEFT JOIN log_aktivitas ON feedback.id_feedback = log_aktivitas.id_feedback
                      LEFT JOIN user AS karyawan ON log_aktivitas.id_karyawan = karyawan.id_user
                      WHERE feedback.id_user = '$id_user'";
$result_feedback_user = $conn->query($sql_feedback_user);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Saya</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="dashboard_user.php">Sistem Feedback | Pengguna</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="kirim_feedback.php">Kirim Feedback</a>
                    </li>
                    <li class="nav-item fw-bold">
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
        <h3 class="mb-4 text-center">Feedback Saya</h3>
        <div class="blockcode">
            <div class="example">
                <div class="card card p-5" style="width: 100%; min-height: 650px; overflow-y: auto;">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Isi</th>
                            <th>Status</th>
                            <th>Nama Karyawan</th>
                            <th>Balasan</th>
                            <th>Tanggal Balasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($feedback = $result_feedback_user->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $feedback['id_feedback']; ?></td>
                                <td><?= $feedback['tanggal_feedback']; ?></td>
                                <td><?= $feedback['nama_kategori']; ?></td>
                                <td><?= $feedback['isi_feedback']; ?></td>
                                <td><?= $feedback['status']; ?></td>
                                <td><?= $feedback['nama_karyawan'] ? $feedback['nama_karyawan'] : '( - )'; ?></td>
                                <td><?= $feedback['balasan'] ? $feedback['balasan'] : '(Belum Dibalas)'; ?></td>
                                <td><?= $feedback['tanggal_balasan'] ? $feedback['tanggal_balasan'] : '( - )'; ?></td>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Kelompok 5 2024</div>
                </div>
            </div>
        </footer>
    </div> 
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script>
        const datatable = new simpleDatatables.DataTable("#datatablesSimple");
    </script>
</body>
</html>
