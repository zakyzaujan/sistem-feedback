<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

if (isset($_POST['id_feedback'])) {
    $id_feedback = $_POST['id_feedback'];

    $sql_update = "UPDATE feedback SET status = 'diproses' WHERE id_feedback = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $id_feedback);
    $stmt->execute();

    header('Location: feedback_diproses.php');
    exit;
} else {
    header('Location: daftar_feedback.php');
    exit;
}
?>
