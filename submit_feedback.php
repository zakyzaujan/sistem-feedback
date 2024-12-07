<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id_user'];
    $isi_feedback = $_POST['isi_feedback'];
    $id_kategori = $_POST['id_kategori'];
    $tanggal_feedback = date('Y-m-d');

    $sql = "INSERT INTO feedback (id_user, tanggal_feedback, isi_feedback, id_kategori, status) 
            VALUES ('$id_user', '$tanggal_feedback', '$isi_feedback', '$id_kategori', 'pending')";

    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard_user.php?status=success');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>