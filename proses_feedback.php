<?php
session_start();
include 'config.php';

// Cek apakah user yang login adalah karyawan
if ($_SESSION['role_user'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}

// Cek apakah ada ID feedback yang dikirim
if (isset($_POST['id_feedback'])) {
    $id_feedback = $_POST['id_feedback'];

    // Query untuk memperbarui status feedback menjadi 'diproses'
    $sql_update = "UPDATE feedback SET status = 'diproses' WHERE id_feedback = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("i", $id_feedback); // Menggunakan parameter binding untuk keamanan
    $stmt->execute();

    // Redirect kembali ke halaman daftar_feedback.php setelah sukses
    header('Location: feedback_diproses.php'); // Pindahkan ke halaman feedback yang diproses
    exit;
} else {
    // Jika tidak ada ID feedback, redirect ke daftar_feedback.php
    header('Location: daftar_feedback.php');
    exit;
}
?>
