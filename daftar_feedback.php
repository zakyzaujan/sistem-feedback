<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

$sql_feedback = "SELECT feedback.*, kategori_feedback.nama_kategori, user.nama_user 
                 FROM feedback 
                 INNER JOIN kategori_feedback ON feedback.id_kategori = kategori_feedback.id_kategori 
                 INNER JOIN user ON feedback.id_user = user.id_user
                 WHERE feedback.status = 'pending'";
$result_feedback = $conn->query($sql_feedback);
?>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
    <div class="alert alert-success">Balasan berhasil dikirim!</div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="dashboard_karyawan.php">Sistem Feedback | Karyawan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="daftar_feedback.php">Daftar Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="feedback_diproses.php">Feedback Diproses</a>
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
        <h3 class="text-center mb-4">Antrian Feedback</h3>
        <div class="blockcode">
            <div class="example">
                <div class="card card p-5" style="width: 100%; min-height: 650px; overflow-y: auto;">
                    <table id="datatablesSimple" class="table table-bordered">
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
                                        <form method="POST" action="proses_feedback.php" style="display:inline;">
                                            <input type="hidden" name="id_feedback" value="<?= $feedback['id_feedback']; ?>">
                                            <button type="submit" class="btn btn-warning btn-sm">Proses</button>
                                        </form>
                                    </td>
                                </tr>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script>
        const datatable = new simpleDatatables.DataTable("#datatablesSimple");
    </script>
</body>
</html>