<?php
session_start();
include 'config.php';

// Query untuk mengambil data log aktivitas (feedback dan balasan)
$sql_log = "SELECT log_aktivitas.*, feedback.isi_feedback, user.nama_user AS nama_pengguna, 
                   karyawan.nama_user AS nama_karyawan
            FROM log_aktivitas
            INNER JOIN feedback ON log_aktivitas.id_feedback = feedback.id_feedback
            INNER JOIN user ON feedback.id_user = user.id_user
            INNER JOIN user AS karyawan ON log_aktivitas.id_karyawan = karyawan.id_user
            ORDER BY log_aktivitas.tanggal_balasan DESC";
$result_log = $conn->query($sql_log);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas</title>
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
                        <a class="nav-link" href="feedback_diproses.php">Feedback Diproses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="log_aktivitas.php">Log Aktivitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h3 class="mb-4">Log Feedback yang Sudah Diproses</h3>
        <div class="blockcode">
            <div class="example">
                <div class="card card p-5" style="width: 100%">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Feedback</th>
                            <th>Isi Feedback</th>
                            <th>Nama Pengguna</th> <!-- Nama Pengguna yang mengirim feedback -->
                            <th>Nama Karyawan</th> <!-- Nama Karyawan yang membalas -->
                            <th>Balasan</th>
                            <th>Tanggal Balasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($log = $result_log->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $log['id_feedback']; ?></td>
                                <td><?= isset($log['isi_feedback']) ? $log['isi_feedback'] : 'Tidak ada feedback'; ?></td>
                                <td><?= isset($log['nama_pengguna']) ? $log['nama_pengguna'] : 'Tidak tersedia'; ?></td>
                                <td><?= isset($log['nama_karyawan']) ? $log['nama_karyawan'] : 'Tidak tersedia'; ?></td>
                                <td><?= isset($log['balasan']) ? $log['balasan'] : 'Tidak ada balasan'; ?></td>
                                <td><?= isset($log['tanggal_balasan']) ? $log['tanggal_balasan'] : 'Tidak tersedia'; ?></td>
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
