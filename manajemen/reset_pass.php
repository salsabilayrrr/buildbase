<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $result = mysqli_query($conn, "SELECT nama FROM users WHERE id = '$id'");
//     $user = mysqli_fetch_assoc($result);
// }

// if (isset($_POST['reset_now'])) {
//     $id = $_POST['id'];
//     $password_baru = mysqli_real_escape_string($conn, $_POST['password']);
    
//     $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);

//     $query = "UPDATE users SET password='$hashed_password' WHERE id='$id'";
//     if (mysqli_query($conn, $query)) {
//         echo "<script>alert('Password Berhasil Direset!'); window.location.href='kelolaPengguna.php';</script>";
//     }
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - BuildBase</title>
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
            <h2 class="main-title">Reset Password <img src="../assets/img/key.png" width="30"></h2>
            <p class="text-muted">User: <strong><?= $user['nama']; ?></strong></p>
        </div>

        <div class="form-container text-center">
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                <input type="password" name="password" placeholder="Masukkan Password Baru *" class="form-input-pill" required>
                
                <button type="submit" name="reset_now" class="btn-submit">Update Password</button>
                <a href="kelolaPengguna.php" class="d-block mt-3 text-secondary" style="text-decoration:none;">Batal</a>
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
        const inputs = document.querySelectorAll('input');

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