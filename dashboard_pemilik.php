<?php
session_start();
include 'config.php';

// Pastikan hanya pemilik yang bisa mengakses dashboard
if ($_SESSION['role_user'] !== 'pemilik') {
    header('Location: index.php');
    exit;
}

// Ambil data pengguna, statistik, atau informasi lainnya
$sql_users = "SELECT COUNT(*) AS total_users FROM user";
$result = $conn->query($sql_users);
$total_users = $result->fetch_assoc()['total_users'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/fontawesome.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 bg-dark text-white">
                <h2 class="text-center py-3">Dashboard</h2>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="dashboard.php" class="nav-link text-white">Dashboard</a></li>
                    <li class="nav-item"><a href="manage_users.php" class="nav-link text-white">Manajemen Pengguna</a></li>
                    <li class="nav-item"><a href="feedback_list.php" class="nav-link text-white">Feedback</a></li>
                    <li class="nav-item"><a href="settings.php" class="nav-link text-white">Pengaturan</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link text-white">Logout</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h3 class="mt-3">Selamat datang di Dashboard Pemilik</h3>
                <div class="row mt-4">
                    <!-- Statistik Pengguna -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title">Jumlah Pengguna</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?= $total_users; ?> pengguna terdaftar.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Statistik Feedback -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title">Jumlah Feedback Positif</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">50 feedback positif.</p> <!-- Ganti dengan data dinamis -->
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Feedback Negatif -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h5 class="card-title">Jumlah Feedback Negatif</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">20 feedback negatif.</p> <!-- Ganti dengan data dinamis -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Pengguna -->
                <h4 class="mt-5">Daftar Pengguna</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pengguna</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_users = "SELECT * FROM user";
                        $result = $conn->query($sql_users);
                        while ($user = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$user['id_user']}</td>
                                    <td>{$user['nama_user']}</td>
                                    <td>{$user['email']}</td>
                                    <td>{$user['role']}</td>
                                    <td>
                                        <a href='edit_user.php?id={$user['id_user']}' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='delete_user.php?id={$user['id_user']}' class='btn btn-danger btn-sm'>Hapus</a>
                                    </td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
