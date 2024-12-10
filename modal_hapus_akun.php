<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'admin') {
    header('Location: index.php');
    exit;
}

if (isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];

    $stmt_select = $conn->prepare("SELECT nama_user FROM user WHERE id_user = ?");
    $stmt_select->bind_param("i", $user_id);
    $stmt_select->execute();
    $stmt_select->bind_result($nama_user);

    if ($stmt_select->fetch()) {
        $stmt_select->close();
        
        // Pindahkan data pengguna yang akan dihapus ke tabel deleted_users
        $stmt_move = $conn->prepare("INSERT INTO deleted_users (id_user, nama_user, email_user, role_user, status_akun, tanggal_bergabung, tanggal_dihapus)
        SELECT id_user, nama_user, email_user, role_user, status_akun, tanggal_bergabung, NOW()
        FROM user WHERE id_user = ?");
        $stmt_move->bind_param("i", $user_id);
        $stmt_move->execute();
        $stmt_move->close();

        // Setelah itu, hapus data dari tabel user
        $stmt_delete = $conn->prepare("DELETE FROM user WHERE id_user = ?");
        $stmt_delete->bind_param("i", $user_id);
        $stmt_delete->execute();

        if ($stmt_delete->execute()) {
            $_SESSION['akun_dihapus'] = 'Akun "' . $nama_user . '" berhasil dihapus.';
            header('Location: manajemen_akun.php');
        } else {
            echo "Error: " . $stmt_delete->error;
        }

        $stmt_delete->close();
    } else {
        echo "Pengguna tidak ditemukan!";
    }

    $stmt_select->close();
} else {
    echo "ID pengguna tidak ditemukan!";
}
?>