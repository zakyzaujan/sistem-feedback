<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

$id_karyawan = $_SESSION['id_user'];

$sql_user = "SELECT nama_user FROM user WHERE id_user = '$id_karyawan'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
$nama_user = $user['nama_user'];

$balasan_dikirim = isset($_SESSION['balasan_dikirim']) ? $_SESSION['balasan_dikirim'] : null;
unset($_SESSION['balasan_dikirim']);

$validasi_gagal = isset($_SESSION['validasi_gagal']) ? $_SESSION['validasi_gagal'] : null;
unset($_SESSION['validasi_gagal']);

$sql_feedback = "SELECT feedback.*, 
                        kategori_feedback.nama_kategori, 
                        user.nama_user 
                 FROM feedback 
                 INNER JOIN kategori_feedback ON feedback.id_kategori = kategori_feedback.id_kategori 
                 INNER JOIN user ON feedback.id_user = user.id_user
                 WHERE feedback.status = 'diproses' AND feedback.id_pemroses = ?
                 ORDER BY feedback.tanggal_feedback ASC";

$stmt = $conn->prepare($sql_feedback);
$stmt->bind_param('i', $id_karyawan);
$stmt->execute();
$result_feedback = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Diproses - Sistem Feedback | Karyawan</title>
    <link href="assets/css/pages/feedback_diproses.css" rel="stylesheet">
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
                                <a class="nav-link fw-bold" href="feedback_diproses.php"><i class="fa-regular fa-folder"></i> Feedback Diproses</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="log_aktivitas.php"><i class="fa-regular fa-file"></i> Log Balasan</a>
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
                <h3 class="text-center mb-4"><i class="fa-regular fa-folder"></i> List Pemrosesan Feedback</h3>
                <p class="text-muted text-center mb-5">Feedback yang sedang diproses oleh karyawan dengan akun ini.</p>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabel Feedback Diproses                             
                    </div>
                    <div class="card-body">
                        <!-- Alert Balasan Dikirm -->
                        <?php if ($balasan_dikirim): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($balasan_dikirim); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <!-- Alert Validasi Gagal -->
                        <?php if ($validasi_gagal): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($validasi_gagal); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <table id="datatablesSimple" class="table table-bordered table-striped" role="table" aria-label="Tabel Feedback Saya">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal Diajukan</th>
                                    <th>Pengguna</th>
                                    <th>Isi Feedback</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_feedback->num_rows > 0) : ?>
                                    <?php while ($feedback = $result_feedback->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= $feedback['id_feedback']; ?></td>
                                            <td><?= $feedback['tanggal_feedback']; ?></td>
                                            <td><?= $feedback['nama_user']; ?></td>
                                            <td title="<?= $feedback['isi_feedback']; ?>"><?= substr($feedback['isi_feedback'], 0, 50); ?><?= strlen($feedback['isi_feedback']) > 50 ? '...' : ''; ?></td>
                                            <td><i>
                                                <?php 
                                                $status_class = '';
                                                $status_text = $feedback['nama_kategori'];

                                                if ($feedback['nama_kategori'] == 'Negatif') {
                                                    $status_class = 'text-danger';
                                                } elseif ($feedback['nama_kategori'] == 'Positif') {
                                                    $status_class = 'text-success';
                                                } elseif ($feedback['nama_kategori'] == 'Saran') {
                                                    $status_class = 'text-primary';
                                                }
                                                ?>
                                                <span class="<?= $status_class; ?>"><?= $status_text; ?></span>
                                            </i></td>
                                            <td><i>
                                                <?php 
                                                $status_class = '';
                                                $status_text = $feedback['status'];

                                                if ($feedback['status'] == 'pending') {
                                                    $status_class = 'text-danger';
                                                    $status_text = 'Pending';
                                                } elseif ($feedback['status'] == 'diproses') {
                                                    $status_class = 'text-warning';
                                                    $status_text = 'Diproses';
                                                } elseif ($feedback['status'] == 'selesai') {
                                                    $status_class = 'text-success';
                                                    $status_text = 'Selesai';
                                                }
                                                ?>
                                                <span class="<?= $status_class; ?>"><?= $status_text; ?></span>
                                            </i></td>
                                            <td>
                                                <a href="balas_feedback.php?id=<?= $feedback['id_feedback']; ?>" class="btn btn-primary btn-sm" title="Balas feedback ini."><i class="fa-solid fa-reply"></i> Balas</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada feedback yang perlu diproses.</td>
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