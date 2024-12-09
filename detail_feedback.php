<?php
session_start();
include 'config.php';

if (isset($_SESSION['role_user'])) {
    $role_user = $_SESSION['role_user'];
} else {
    header('Location: login.php');
    exit;
}

$role_user = $_SESSION['role_user'];

if (isset($_GET['id_feedback'])) {
    $id_feedback = $_GET['id_feedback'];

    $sql_detail = "SELECT feedback.*, 
                          user.nama_user AS nama_pengguna, 
                          karyawan.nama_user AS nama_karyawan, 
                          kategori_feedback.nama_kategori,
                          log_aktivitas.balasan, 
                          log_aktivitas.tanggal_balasan 
                  FROM feedback 
                  LEFT JOIN user ON feedback.id_user = user.id_user 
                  LEFT JOIN log_aktivitas ON feedback.id_feedback = log_aktivitas.id_feedback 
                  LEFT JOIN user AS karyawan ON log_aktivitas.id_karyawan = karyawan.id_user 
                  INNER JOIN kategori_feedback ON feedback.id_kategori = kategori_feedback.id_kategori 
                  WHERE feedback.id_feedback = ?";
    $stmt = $conn->prepare($sql_detail);
    $stmt->bind_param("i", $id_feedback);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $feedback = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID Feedback tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Feedback - Sistem Feedback | Karyawan</title>
    <link href="assets/css/pages/detail_feedback.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="<?= $role_user; ?>"></div>
        <div class="main-content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <a href="<?php echo ($role_user == 'karyawan') ? 'log_aktivitas.php' : 'feedback_saya.php'; ?>" class="btn btn-warning"> <i class="fa-solid fa-arrow-left"></i> Kembali </a>
                </div>
            </nav>

            <div class="container animation mt-5">
                <h3 class="text-center mb-4"><i class="fa-solid fa-circle-info"></i> Detail Feedback</h3>
                <p class="text-muted text-center mb-5">Menampilkan dengan detail informasi feedback yang diberikan oleh pengguna.</p>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-file-lines"></i> Detail Feedback #<?= $feedback['id_feedback']; ?>                           
                        </div>
                        <div class="card-body">
                            <!-- Feedback Info Section -->
                            <div class="feedback-detail">
                                <h5 class="section-title">Informasi Feedback:</h5>
                                <ul class="info-list">
                                    <li><strong>Pengguna:</strong> <span class="text-primary"><?= htmlspecialchars($feedback['nama_pengguna']); ?></span></li>
                                    <li><strong>Tanggal Kirim:</strong> <?= htmlspecialchars($feedback['tanggal_feedback']); ?></li>
                                    <li><strong>Tipe Feedback:</strong> 
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
                                    </li>
                                    <li><strong>Isi Feedback:</strong> <?= nl2br(htmlspecialchars($feedback['isi_feedback'])); ?></li>
                                </ul>
                            </div>

                            <!-- Balasan Info Section -->
                            <div class="reply-detail">
                                <h5 class="section-title">Balasan:</h5>
                                <?php if ($feedback['balasan']) : ?>
                                    <ul class="info-list">
                                        <li><strong>Karyawan:</strong> <span class="text-success"><?= htmlspecialchars($feedback['nama_karyawan']); ?></span></li>
                                        <li><strong>Tanggal Balasan:</strong> <?= htmlspecialchars($feedback['tanggal_balasan']); ?></li>
                                        <li><strong>Isi Balasan:</strong> <?= nl2br(htmlspecialchars($feedback['balasan'])); ?></li>
                                    </ul>
                                <?php else : ?>
                                    <p><em>Belum ada balasan untuk feedback ini.</em></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="<?= $role_user; ?>"></div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>