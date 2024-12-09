<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

if (isset($_GET['id'])) {
    $id_feedback = $_GET['id'];

    $sql_feedback = "SELECT feedback.*, 
                            kategori_feedback.nama_kategori, 
                            user.nama_user 
                     FROM feedback 
                     INNER JOIN kategori_feedback ON feedback.id_kategori = kategori_feedback.id_kategori 
                     INNER JOIN user ON feedback.id_user = user.id_user
                     WHERE feedback.id_feedback = ?";
    $stmt = $conn->prepare($sql_feedback);
    $stmt->bind_param("i", $id_feedback);
    $stmt->execute();
    $result_feedback = $stmt->get_result();
    $feedback = $result_feedback->fetch_assoc();

    if (!$feedback) {
        header('Location: daftar_feedback.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $balasan = $_POST['balasan'];

    $sql_update = "UPDATE feedback SET status = 'selesai' WHERE id_feedback = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $id_feedback);
    $stmt_update->execute();

    $id_karyawan = $_SESSION['id_user'];
    $sql_log = "INSERT INTO log_aktivitas (id_feedback, id_karyawan, balasan, tanggal_balasan) 
                VALUES (?, ?, ?, NOW())";
    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->bind_param("iis", $id_feedback, $id_karyawan, $balasan);
    $stmt_log->execute();

    $_SESSION['balasan_dikirim'] = "Balasan berhasil dikirim!";
    header('Location: feedback_diproses.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balas Feedback - Sistem Feedback | Karyawan</title>
    <link href="assets/css/pages/balas_feedback.css" rel="stylesheet">
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
                    <a href="feedback_diproses.php" class="btn btn-warning"> <i class="fa-solid fa-arrow-left"></i> Kembali </a>
                </div>
            </nav>

            <div class="container animation mt-5">
                <h3 class="mb-4 text-center"><i class="fa-solid fa-reply"></i> Balas Feedback</h3>
                <p class="text-muted text-center">Berikan respons terhadap feedback yang diberikan oleh pengguna.</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="col-md-8 col-lg-7">
                            <div class="info-card p-4">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label for="isi_feedback" class="form-label">Isi Feedback #<?= $id_feedback; ?></label>
                                        <textarea class="form-control" id="isi_feedback" rows="9" readonly><?= $feedback['isi_feedback']; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="balasan" class="form-label">Balasan</label>
                                        <textarea class="form-control" id="balasan" name="balasan" rows="7" required></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-3"><i class="fa-regular fa-paper-plane"></i>  Kirim Balasan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>

        </div>
        <div class="side-wallpaper"></div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>