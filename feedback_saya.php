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
    <link href="assets/css/pages/feedback_saya.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="dashboard_user.php" id="judul"><i class="fa-solid fa-house"></i> Sistem Feedback | Pengguna</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item me-2">
                                <a class="nav-link" href="kirim_feedback.php"><i class="fa-regular fa-comment"></i> Kirim Feedback</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link fw-bold" href="feedback_saya.php" id="laman_sekarang"><i class="fa-regular fa-folder"></i> Feedback Saya</a>
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

            <div class="container animation mt-5">
                <h3 class="mb-4 text-center"><i class="fa-regular fa-folder"></i> Feedback Saya</h3>
                <p class="text-muted text-center mb-5">Feedback yang sudah pernah diajukan.</p>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tabel Feedback Saya                               
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered table-striped" role="table" aria-label="Tabel Feedback Saya">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Kategori</th>
                                        <th>Isi Feedback</th>
                                        <th>Status</th>
                                        <th>Tanggal Balasan</th>
                                        <th>Balasan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result_feedback_user->num_rows > 0) : ?>
                                        <?php while ($feedback = $result_feedback_user->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?= $feedback['id_feedback']; ?></td>
                                                <td><?= $feedback['tanggal_feedback']; ?></td>
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
                                                <td title="<?= $feedback['isi_feedback']; ?>"><?= substr($feedback['isi_feedback'], 0, 20); ?><?= strlen($feedback['isi_feedback']) > 20 ? '...' : ''; ?></td>
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
                                                <td><?= $feedback['tanggal_balasan'] ? $feedback['tanggal_balasan'] : '-'; ?></td>
                                                <td title="<?= !empty($feedback['balasan']) ? $feedback['balasan'] : 'Tidak ada balasan'; ?>">
                                                    <?= !empty($feedback['balasan']) ? substr($feedback['balasan'], 0, 20) . (strlen($feedback['balasan']) > 20 ? '...' : '') : '-'; ?>
                                                </td>
                                                <td><a href="detail_feedback.php?id_feedback=<?= $feedback['id_feedback']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-info"></i> Detail</a></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Belum ada feedback yang diajukan.</td>
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