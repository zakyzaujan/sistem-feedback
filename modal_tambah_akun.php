<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'admin') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("INSERT INTO user (nama_user, email_user, role_user, password_user, status_akun, tanggal_bergabung) 
    VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $nama_user, $email_user, $role_user, $password_user, $status_akun);

    $nama_user = $_POST['nama_user'];
    $email_user = $_POST['email_user'];
    $role_user = $_POST['role_user'];
    $password_user = $_POST['password_user'];
    $status_akun = 'aktif';

    if ($stmt->execute()) {
    $_SESSION['akun_ditambah'] = 'Akun "' . $nama_user . '" berhasil ditambahkan.';
    header('Location: manajemen_akun.php');
    } else {
    echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
