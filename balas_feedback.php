<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

if (isset($_GET['id'])) {
    $id_feedback = $_GET['id'];

    $sql_feedback = "SELECT feedback.*, kategori_feedback.nama_kategori, user.nama_user 
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
    $tanggal_balasan = date('Y-m-d H:i:s');
    $sql_log = "INSERT INTO log_aktivitas (id_feedback, id_karyawan, balasan, tanggal_balasan) 
                VALUES (?, ?, ?, ?)";
    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->bind_param("iiss", $id_feedback, $id_karyawan, $balasan, $tanggal_balasan);
    $stmt_log->execute();

    header('Location: feedback_diproses.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balas Feedback</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h3 class="mb-4">Balas Feedback</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="isi_feedback" class="form-label">Isi Feedback</label>
                <textarea class="form-control" id="isi_feedback" rows="4" readonly><?= $feedback['isi_feedback']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="balasan" class="form-label">Balasan</label>
                <textarea class="form-control" id="balasan" name="balasan" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Kirim Balasan</button>
        </form>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
