<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'admin') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_nama_user'], $_POST['edit_email_user'], $_POST['edit_role_user'], $_POST['edit_user_id'])) {
        $nama_user = $_POST['edit_nama_user'];
        $email_user = $_POST['edit_email_user'];
        $role_user = $_POST['edit_role_user'];
        $user_id = $_POST['edit_user_id'];

        if (!filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
            echo "Email tidak valid!";
            exit;
        }

        $stmt = $conn->prepare("UPDATE user SET nama_user = ?, email_user = ?, role_user = ? WHERE id_user = ?");
        $stmt->bind_param("sssi", $nama_user, $email_user, $role_user, $user_id);

        if ($stmt->execute()) {
            $_SESSION['akun_diedit'] = "Akun berhasil diperbarui.";
            header('Location: manajemen_akun.php');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Data tidak lengkap!";
    }
}
?>
