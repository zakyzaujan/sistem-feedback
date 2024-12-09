<?php
session_start();
include 'config.php';

// Cek apakah pengguna adalah admin
if ($_SESSION['role_user'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$sql_log = "SELECT log_aktivitas.*, 
                   feedback.isi_feedback, 
                   user.nama_user AS nama_pengguna, 
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
    <title>Daftar Feedback - Sistem Feedback | Admin</title>
    <link href="assets/css/pages/semua_feedback.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
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
                    <a class="navbar-brand" href="dashboard_admin.php" id="judul"><i class="fa-solid fa-house"></i> Sistem Feedback | Admin</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item me-2">
                                <a class="nav-link" href="manajemen_akun.php"><i class="fa-solid fa-list-check"></i> Manajemen Akun</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link fw-bold" href="semua_feedback.php"><i class="fa-regular fa-folder"></i> Log Feedback</a>
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

            <div class="container animation mt-5">
                <h3 class="text-center mb-4"><i class="fa-regular fa-folder"></i> Log Feedback</h3>
                <p class="text-muted text-center mb-5">Berisikan semua feedback yang telah diproses oleh karyawan.</p>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabel Log Aktivitas                            
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered table-striped" role="table" aria-label="Tabel Feedback Saya">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Pengguna</th>
                                <th>Isi</th>
                                <th>Karyawan</th>
                                <th>Balasan</th>
                                <th>Tanggal Balasan</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_log->num_rows > 0) : ?>
                                    <?php while ($log = $result_log->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= isset($log['id_feedback']) ? $log['id_feedback'] : 'Tidak tersedia'; ?></td>
                                            <td><?= isset($log['nama_pengguna']) ? $log['nama_pengguna'] : 'Tidak tersedia'; ?></td>
                                            <td title="<?= $log['isi_feedback']; ?>"><?= substr($log['isi_feedback'], 0, 30); ?><?= strlen($log['isi_feedback']) > 30 ? '...' : ''; ?></td>
                                            <td><?= isset($log['nama_karyawan']) ? $log['nama_karyawan'] : 'Tidak tersedia'; ?></td>
                                            <td title="<?= $log['balasan']; ?>"><?= substr($log['balasan'], 0, 30); ?><?= strlen($log['balasan']) > 30 ? '...' : ''; ?></td>
                                            <td><?= isset($log['tanggal_balasan']) ? $log['tanggal_balasan'] : 'Tidak tersedia'; ?></td>
                                            <td><a href="detail_feedback.php?id_feedback=<?= $log['id_feedback']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-info"></i> Detail</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada log aktivitas yang tersedia.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="side-wallpaper"></div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script>
        const datatable = new simpleDatatables.DataTable("#datatablesSimple");
    </script>
</body>
</html>