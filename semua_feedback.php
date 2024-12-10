<?php
session_start();
include 'config.php';

// Cek apakah pengguna adalah admin
if ($_SESSION['role_user'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user'];
$sql_user = "SELECT nama_user FROM user WHERE id_user = '$id_user'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
$nama_user = $user['nama_user'];

// Query untuk menghitung total feedback
$query_total_feedback = "SELECT COUNT(*) AS total_feedback FROM feedback";
$result_total_feedback = $conn->query($query_total_feedback);
$total_feedback = $result_total_feedback->fetch_assoc()['total_feedback'];

// Query untuk menampilkan data dari tabel feedback
$sql_feedback = "SELECT feedback.*, 
                        user.nama_user AS nama_pengguna,
                        kategori_feedback.nama_kategori 
                 FROM feedback 
                 INNER JOIN user ON feedback.id_user = user.id_user
                 INNER JOIN kategori_feedback ON feedback.id_kategori = kategori_feedback.id_kategori
                 ORDER BY feedback.tanggal_feedback ASC";
$result_feedback = $conn->query($sql_feedback);
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
                    <a class="navbar-brand" href="dashboard_admin.php" id="judul"><i class="fa-solid fa-house"></i> Sistem Feedback | <?=$nama_user;?></a>
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
                <p class="text-muted text-center mb-5">Berisi semua feedback yang pernah diajukan oleh pengguna.</p>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabel Log Feedback
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered table-striped" role="table" aria-label="Tabel Feedback Saya">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Pengguna</th>
                                    <th>Kategori</th>
                                    <th>Isi Feedback</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_feedback->num_rows > 0) : ?>
                                    <?php while ($feedback = $result_feedback->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?= isset($feedback['id_feedback']) ? $feedback['id_feedback'] : 'Tidak tersedia'; ?></td>
                                            <td><?= isset($feedback['tanggal_feedback']) ? $feedback['tanggal_feedback'] : 'Tidak tersedia'; ?></td>
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
                                            <td><?= isset($feedback['nama_pengguna']) ? $feedback['nama_pengguna'] : 'Tidak tersedia'; ?></td>
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
                                            <td title="<?= $feedback['isi_feedback']; ?>"><?= substr($feedback['isi_feedback'], 0, 55); ?><?= strlen($feedback['isi_feedback']) > 55 ? '...' : ''; ?></td>
                                            <td><a href="detail_feedback.php?id_feedback=<?= $feedback['id_feedback']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-info"></i> Detail</a></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada feedback yang tersedia.</td>
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
