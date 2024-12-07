<?php
session_start();
include 'config.php';

// Cek jika pengguna memiliki hak akses
if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

// Query untuk mendapatkan feedback yang statusnya diproses
$sql_feedback = "SELECT feedback.*, kategori_feedback.nama_kategori, user.nama_user 
                 FROM feedback 
                 INNER JOIN kategori_feedback ON feedback.id_kategori = kategori_feedback.id_kategori 
                 INNER JOIN user ON feedback.id_user = user.id_user
                 WHERE feedback.status = 'diproses'";  // Hanya ambil feedback yang statusnya diproses
$result_feedback = $conn->query($sql_feedback);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Diproses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="dashboard_karyawan.php">Sistem Feedback | Karyawan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="daftar_feedback.php">Daftar Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="feedback_diproses.php">Feedback Diproses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="log_aktivitas.php">Log Aktivitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h3 class="mb-4">Feedback yang Sedang Diproses</h3>
        <div class="blockcode">
            <div class="example">
                <div class="card card p-5" style="width: 100%">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Pengguna</th>
                            <th>Tanggal</th>
                            <th>Isi Feedback</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($feedback = $result_feedback->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $feedback['id_feedback']; ?></td>
                                <td><?= $feedback['nama_user']; ?></td>
                                <td><?= $feedback['tanggal_feedback']; ?></td>
                                <td><?= $feedback['isi_feedback']; ?></td>
                                <td><?= $feedback['nama_kategori']; ?></td>
                                <td><?= $feedback['status']; ?></td>
                                <td>
                                    <!-- Tombol Balas untuk memberikan balasan pada feedback -->
                                    <a href="balas_feedback.php?id=<?= $feedback['id_feedback']; ?>" class="btn btn-primary btn-sm">Balas</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
