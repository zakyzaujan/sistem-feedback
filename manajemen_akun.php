<?php
session_start();
include 'config.php';

// Cek apakah pengguna adalah admin
if ($_SESSION['role_user'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$akun_ditambah = isset($_SESSION['akun_ditambah']) ? $_SESSION['akun_ditambah'] : null;
unset($_SESSION['akun_ditambah']);

$akun_diedit = isset($_SESSION['akun_diedit']) ? $_SESSION['akun_diedit'] : null;
unset($_SESSION['akun_diedit']);

$akun_dihapus = isset($_SESSION['akun_dihapus']) ? $_SESSION['akun_dihapus'] : null;
unset($_SESSION['akun_dihapus']);

$id_user = $_SESSION['id_user'];
$sql_user = "SELECT nama_user FROM user WHERE id_user = '$id_user'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
$nama_user = $user['nama_user'];

$query_users = "SELECT * FROM user";
$result_users = $conn->query($query_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun - Sistem Feedback | Admin</title>
    <link href="assets/css/pages/manajemen_akun.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
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

        .animation {
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
                    <a class="navbar-brand" href="dashboard_admin.php" id="judul"><i class="fa-solid fa-house"></i> Sistem Feedback | <?=$nama_user;?></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item me-2">
                                <a class="nav-link fw-bold" href="manajemen_akun.php"><i class="fa-solid fa-list-check"></i> Manajemen Akun</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="semua_feedback.php"><i class="fa-regular fa-folder"></i> Log Feedback</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-secondary" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="profil_admin.php"><i class="fa-solid fa-user"></i> | Profil</a></li>
                                    <li><a class="dropdown-item" href="logout.php"><i class="fa-solid fa-power-off"></i> | Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container animation mt-5">
                <h3 class="mb-4 text-center"><i class="fa-solid fa-list-check"></i> Manajemen Akun</h3>
                <p class="text-muted text-center mb-5">Lihat informasi mengenai semua akun yang terdaftar.</p>
                    <div class="text-start">
                        <a class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fa-solid fa-user-plus"></i> Tambah Akun Baru</a>   
                    </div> 
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabel Daftar Akun                          
                    </div>
                    <div class="card-body">
                        <!-- Alert Akun Ditambah -->
                        <?php if ($akun_ditambah): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($akun_ditambah); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Alert Akun Diedit -->
                        <?php if ($akun_diedit): ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($akun_diedit); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Alert Akun Dihapus -->
                        <?php if ($akun_dihapus): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($akun_dihapus); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <table id="datatablesSimple" class="table table-bordered table-striped" role="table" aria-label="Tabel Feedback Saya">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Pengguna</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_users->num_rows > 0): ?>
                                    <?php $no = 1; while ($user = $result_users->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $user['id_user'] ?></td>
                                            <td><?= $user['nama_user'] ?></td>
                                            <td><?= $user['email_user'] ?></td>
                                            <td>
                                                <?php 
                                                $status_class = '';
                                                $status_text = $user['role_user'];

                                                if ($user['role_user'] == 'admin') {
                                                    $status_class = 'text-danger';
                                                    $status_text = 'Admin';
                                                } elseif ($user['role_user'] == 'pengguna') {
                                                    $status_class = 'text-success';
                                                    $status_text = 'Pengguna';
                                                } elseif ($user['role_user'] == 'karyawan') {
                                                    $status_class = 'text-primary';
                                                    $status_text = 'Karyawan';
                                                }
                                                ?>
                                                <span class="<?= $status_class; ?>"><?= $status_text; ?></span>
                                            </td>
                                            <td>
                                                <i class="<?= $user['status_akun'] === 'aktif' ? 'text-success' : 'text-danger' ?>">
                                                    <?= $user['status_akun'] === 'aktif' ? 'Aktif' : 'Tidak Aktif' ?>
                                                </i>
                                            </td>
                                            <td><?= $user['tanggal_bergabung'] ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                        data-id="<?= $user['id_user'] ?>"
                                                        data-nama="<?= $user['nama_user'] ?>"
                                                        data-email="<?= $user['email_user'] ?>"
                                                        data-role="<?= $user['role_user'] ?>"
                                                        data-status="<?= $user['status_akun'] ?>">
                                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                                </button>
                                                    
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                                        data-id="<?= $user['id_user'] ?>"
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada akun ditemukan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="side-wallpaper"></div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel"><i class="fa-solid fa-user-plus"></i> Tambah Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form tambah pengguna -->
                    <form action="modal_tambah_akun.php" method="POST">
                        <div class="mb-3">
                            <label for="nama_user" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_user" name="nama_user" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_user" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_user" name="email_user" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_user" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password_user" name="password_user" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_user" class="form-label">Role</label>
                            <select class="form-select" id="role_user" name="role_user">
                                <option value="admin">1 - Admin</option>
                                <option value="karyawan">2 - Karyawan</option>
                                <option value="pengguna">3 - Pengguna</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success mt-2 mb-2"><i class="fa-solid fa-plus"></i> Tambahkan Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengguna -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel"><i class="fa-regular fa-pen-to-square"></i> Edit Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form edit pengguna -->
                    <form action="modal_edit_akun.php" method="POST">
                        <input type="hidden" id="edit_user_id" name="edit_user_id">
                        <div class="mb-3">
                            <label for="edit_nama_user" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_nama_user" name="edit_nama_user" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email_user" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email_user" name="edit_email_user" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role_user" class="form-label">Role</label>
                            <select class="form-select" id="edit_role_user" name="edit_role_user">
                                <option value="admin">1 - Admin</option>
                                <option value="karyawan">2 - Karyawan</option>
                                <option value="pengguna">3 - Pengguna</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status_akun" class="form-label">Role</label>
                            <select class="form-select" id="edit_status_akun" name="edit_status_akun">
                                <option value="aktif">1 - Aktif</option>
                                <option value="tidak aktif">2 - Tidak Aktif</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning mt-2 mb-2">
                            <i class="fa-regular fa-pen-to-square"></i> Update Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Pengguna -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel"><i class="fa-solid fa-trash"></i> Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun ini?</p>
                    <form action="modal_hapus_akun.php" method="POST">
                        <input type="hidden" id="delete_user_id" name="delete_user_id" value="">
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script>
        const datatable = new simpleDatatables.DataTable("#datatablesSimple");
    </script>
    <script>
        // Modal Edit
        const editUserModal = document.getElementById('editUserModal');

        editUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const userId = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const email = button.getAttribute('data-email');
            const role = button.getAttribute('data-role');
            const status = button.getAttribute('data-status');

            const inputUserId = editUserModal.querySelector('#edit_user_id');
            const inputNama = editUserModal.querySelector('#edit_nama_user');
            const inputEmail = editUserModal.querySelector('#edit_email_user');
            const selectRole = editUserModal.querySelector('#edit_role_user');
            const selectStatus = editUserModal.querySelector('#edit_status_akun');

            inputUserId.value = userId;
            inputNama.value = nama;
            inputEmail.value = email;
            selectRole.value = role;
            selectStatus.value = status;
        });
    </script>
    <script>
        // Modal Hapus
        const deleteUserModal = document.getElementById('deleteUserModal');
        deleteUserModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const userId = button.getAttribute('data-id');

            const inputDeleteUserId = deleteUserModal.querySelector('#delete_user_id');
            inputDeleteUserId.value = userId;
        });
    </script>
</body>
</html>
