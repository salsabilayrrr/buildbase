<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id'");
//     $user = mysqli_fetch_assoc($result);
// }

// if (isset($_POST['update_profile'])) {
//     $id = $_POST['id'];
//     $nama = mysqli_real_escape_string($conn, $_POST['nama']);
//     $email = mysqli_real_escape_string($conn, $_POST['email']);
//     $role = mysqli_real_escape_string($conn, $_POST['role']);

//     $query = "UPDATE users SET nama='$nama', email='$email', role='$role' WHERE id='$id'";
    
//     if (mysqli_query($conn, $query)) {
//         echo "<script>
//                 alert('Berhasil! Data pengguna telah diperbarui.'); 
//                 window.location.href='kelolaPengguna.php';
//               </script>";
//     } else {
//         echo "<script>alert('Gagal memperbarui data.');</script>";
//     }
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleInputUserManager.css">
</head>
<body>
    <header class="dashboard-header">
            <div class="header-left">
                <img src="../assets/img/logo.png" class="header-logo" alt="Logo">
                <span class="header-title">Manajemen</span>
            </div>
            <a href="../logout.php" class="btn-logout-pill">
                <div class="logout-icon-box">
                    <img src="../assets/img/logout.png" alt="Logout">
                </div>
                <span class="logout-text">Logout</span>
            </a>
        </header>

    <main class="scroll-content">
        <div class="title-section">
            <h2 class="main-title">Edit Profil User <img src="../assets/img/edit.png" width="30"></h2>
        </div>

        <div class="form-container text-center">
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?= $user['id']; ?>">
                
                <span class="sub-label">Nama Lengkap *</span>
                <input type="text" name="nama" value="<?= $user['nama']; ?>" class="form-input-pill" required>
                
                <span class="sub-label">Email Akun *</span>
                <input type="email" name="email" value="<?= $user['email']; ?>" class="form-input-pill" required>
                
                <span class="sub-label">Pilih Role Jabatan *</span>
                <select class="form-input-pill" name="role" required>
                    <option value="">Select Role</option>
                    <option value="cs" <?= ($user['role'] == 'cs') ? 'selected' : ''; ?>>Customer Service</option>
                    <option value="estimator" <?= ($user['role'] == 'estimator') ? 'selected' : ''; ?>>Estimator</option>
                    <option value="drafter" <?= ($user['role'] == 'drafter') ? 'selected' : ''; ?>>Drafter</option>
                    <option value="engineer" <?= ($user['role'] == 'engineer') ? 'selected' : ''; ?>>Engineer</option>
                    <option value="finance" <?= ($user['role'] == 'finance') ? 'selected' : ''; ?>>Finance</option>
                    <option value="manager" <?= ($user['role'] == 'manager') ? 'selected' : ''; ?>>Manager</option>
                    <option value="qc" <?= ($user['role'] == 'qc') ? 'selected' : ''; ?>>Quality Control</option>
                </select>

                <button type="submit" name="update_profile" class="btn-submit">Simpan Perubahan</button>
                <a href="kelolaPengguna.php" class="d-block mt-3 text-secondary" style="text-decoration:none; font-weight:700;">Batal</a>
            </form>
        </div>
    </main>

    <nav class="bottom-nav" id="navbar">
            <div class="nav-item">
                <a href="persetujuanProduksi.php">
                    <img src="../assets/img/berkas.png" class="nav-icon-side">
                </a>
            </div>
            <div class="nav-item">
                <a href="penolakan.php">
                    <img src="../assets/img/arsip.jpg" class="nav-icon-side">
                </a>
            </div>
            <div class="nav-item">
                <a href="../dashboard/manager.php">
                    <img src="../assets/img/home.png" class="nav-icon-side">
                </a>
            </div>
            <div class="nav-item">
                <div class="active-extra-circle">
                    <a href="kelolaPengguna.php">
                        <img src="../assets/img/akun.jpg" class="nav-icon-active">
                    </a>
                </div>
            </div>
        </nav>

    <script>
        const navbar = document.getElementById('navbar');
        const inputs = document.querySelectorAll('input, select');

        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                navbar.classList.add('hidden-nav');
            });
            input.addEventListener('blur', () => {
                navbar.classList.remove('hidden-nav');
            });
        });
    </script>
</body>
</html>