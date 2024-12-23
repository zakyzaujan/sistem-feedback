<?php
session_start();
include 'config.php';

$id_karyawan_login = $_SESSION['id_user'];

$sql_user = "SELECT nama_user FROM user WHERE id_user = '$id_karyawan_login'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
$nama_user = $user['nama_user'];

if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

$sql_log = "SELECT log_aktivitas.*, 
                   feedback.isi_feedback, 
                   feedback.id_kategori, 
                   kategori_feedback.nama_kategori, 
                   user.nama_user AS nama_pengguna, 
                   karyawan.nama_user AS nama_karyawan
            FROM log_aktivitas
            INNER JOIN feedback ON log_aktivitas.id_feedback = feedback.id_feedback
            INNER JOIN kategori_feedback ON feedback.id_kategori = kategori_feedback.id_kategori
            INNER JOIN user ON feedback.id_user = user.id_user
            INNER JOIN user AS karyawan ON log_aktivitas.id_karyawan = karyawan.id_user
            WHERE log_aktivitas.id_karyawan = ?
            ORDER BY log_aktivitas.tanggal_balasan ASC";
            
$stmt = $conn->prepare($sql_log);
$stmt->bind_param("i", $id_karyawan_login);
$stmt->execute();

$result_log = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas - Sistem Feedback | Karyawan</title>
    <link href="assets/css/pages/log_aktivitas.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="dashboard_karyawan.php" id="judul"><i class="fa-solid fa-house"></i> Sistem Feedback | <?=$nama_user;?></a>
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
                                <a class="nav-link fw-bold" href="log_aktivitas.php"><i class="fa-regular fa-file"></i> Log Balasan</a>
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

            <div class="container animation mt-5">
                <h3 class="text-center mb-4"><i class="fa-regular fa-file"></i> Log Balasan Feedback</h3>
                <p class="text-muted text-center mb-5">Feedback yang selesai diproses oleh karyawan dengan akun ini.</p>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabel Log Balasan                            
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered table-striped" role="table" aria-label="Tabel Feedback Saya">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Tanggal Dibalas</th>
                                <th>Pengguna</th>
                                <th>Isi Feedback</th>
                                <th>Balasan Feedback</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_log->num_rows > 0) : ?>
                                    <?php while ($log = $result_log->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= isset($log['id_feedback']) ? $log['id_feedback'] : 'Tidak tersedia'; ?></td>
                                            <td><?= isset($log['tanggal_balasan']) ? $log['tanggal_balasan'] : 'Tidak tersedia'; ?></td>
                                            <td><?= isset($log['nama_pengguna']) ? $log['nama_pengguna'] : 'Tidak tersedia'; ?></td>
                                            <td title="<?= $log['isi_feedback']; ?>"><?= substr($log['isi_feedback'], 0, 30); ?><?= strlen($log['isi_feedback']) > 30 ? '...' : ''; ?></td>
                                            <td title="<?= $log['balasan']; ?>"><?= substr($log['balasan'], 0, 30); ?><?= strlen($log['balasan']) > 30 ? '...' : ''; ?></td>  
                                            <td><i>
                                                <?php 
                                                $status_class = '';
                                                $status_text = $log['nama_kategori'];

                                                if ($log['nama_kategori'] == 'Negatif') {
                                                    $status_class = 'text-danger';
                                                } elseif ($log['nama_kategori'] == 'Positif') {
                                                    $status_class = 'text-success';
                                                } elseif ($log['nama_kategori'] == 'Saran') {
                                                    $status_class = 'text-primary';
                                                }
                                                ?>
                                                <span class="<?= $status_class; ?>"><?= $status_text; ?></span>
                                            </i></td>
                                            <td><a href="detail_feedback.php?id_feedback=<?= $log['id_feedback']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-info"></i> Detail</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada log aktivitas yang tersedia.</td>
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