<?php
session_start();
include 'config.php';

if ($_SESSION['role_user'] !== 'pengguna') {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user']; 

$result_kategori = $conn->query("SELECT * FROM kategori_feedback");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Feedback</title>
    <link href="assets/css/pages/kirim_feedback.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animation{
            animation: fadeIn 0.3s ease;
        }
    </style>
</head>
<body class="bg-light">
    <div class="wrapper">
        <div class="side-wallpaper"></div>
        <div class="main-content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <a class="navbar-brand" href="dashboard_user.php" id="judul"><i class="fa-solid fa-house"></i> Sistem Feedback | Pengguna</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item me-2">
                                <a class="nav-link fw-bold" href="kirim_feedback.php" id="laman_sekarang"><i class="fa-regular fa-comment"></i> Kirim Feedback</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="feedback_saya.php"><i class="fa-regular fa-folder"></i> Feedback Saya</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="profil_user.php"><i class="fa-solid fa-magnifying-glass"></i></i> | Info Profil</a></li>
                                    <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-power-off"></i> | Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container animation mt-5">
                <h2 class="mb-4 text-center"><i class="fa-regular fa-comment"></i> Kirim Feedback</h2>
                <p class="text-muted text-center mb-5">Kirimkan feedback berupa hal positif, negatif, ataupun saran.</p>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-7">
                        <div class="info-card p-4">
                            <?php if (isset($_SESSION['feedback_status'])) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= $_SESSION['feedback_status']; ?>
                                    <?php unset($_SESSION['feedback_status']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="submit_feedback.php" class="mt-3">
                                <div class="mb-3">
                                    <label for="isi_feedback" class="form-label">Isi Feedback</label>
                                    <textarea name="isi_feedback" id="isi_feedback" class="form-control" rows="9" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="id_kategori" class="form-label">Kategori Feedback</label>
                                    <select name="id_kategori" id="id_kategori" class="form-select" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php if ($result_kategori->num_rows > 0) : ?>
                                            <?php while ($kategori = $result_kategori->fetch_assoc()) : ?>
                                                <option value="<?= htmlspecialchars($kategori['id_kategori']); ?>">
                                                    <?= htmlspecialchars($kategori['id_kategori']) . ' - ' . htmlspecialchars($kategori['nama_kategori']); ?>
                                                </option>
                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <option value="" disabled>Tidak ada kategori tersedia</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-3"><i class="fa-regular fa-paper-plane"></i> Kirim Feedback</button>
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
        <div class="side-wallpaper"></div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>