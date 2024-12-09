<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_feedback = $_POST['id_feedback'];
    $id_karyawan = $_SESSION['id_user'];

    $sql_update = "UPDATE feedback SET status = 'diproses', id_pemroses = ? WHERE id_feedback = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param('ii', $id_karyawan, $id_feedback);

    if ($stmt->execute()) {
        $_SESSION['feedback_diproses'] = "Feedback berhasil diproses.";
    } else {
        $_SESSION['feedback_diproses'] = "Terjadi kesalahan saat memproses feedback.";
    }

    header('Location: daftar_feedback.php');
    exit;
}
?>