<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['id_user'];
    $isi_feedback = $conn->real_escape_string($_POST['isi_feedback']);
    $id_kategori = $conn->real_escape_string($_POST['id_kategori']);

    $sql = "INSERT INTO feedback (id_user, isi_feedback, id_kategori, tanggal_feedback) 
            VALUES ('$id_user', '$isi_feedback', '$id_kategori', NOW())";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['feedback_status'] = "Feedback berhasil dikirim.";
    } else {
        $_SESSION['feedback_status'] = "Terjadi kesalahan, coba lagi.";
    }

    header('Location: kirim_feedback.php');
    exit;
}
?>