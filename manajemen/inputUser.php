<?php
include "../koneksi.php";

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']);

    $query = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data User Berhasil Disimpan!');
                window.location.href='kelolaPengguna.php';
                </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input User - Manajemen</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
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
            <h2 class="main-title">
                Input User 
                <img src="../assets/img/inputUser.png" width="40" alt="Icon">
            </h2>
        </div>

        <div class="form-container text-center">
            <form action="" method="POST">
                <input type="text" name="nama" placeholder="Nama Lengkap *" class="form-input-pill" required>
                <input type="text" name="tgl_lahir" placeholder="Tanggal Lahir *" class="form-input-pill" onfocus="(this.type='date')">
                <input type="text" name="role" placeholder="Role *" class="form-input-pill" required>
                <input type="email" name="email" placeholder="Email *" class="form-input-pill" required>
                <input type="password" name="password" placeholder="Password *" class="form-input-pill" required>
                
                <button type="submit" name="submit" class="btn-submit">Submit</button>
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
            navbar.style.transform = 'translateY(150px)';
            navbar.style.opacity = '0';
        });
        
        input.addEventListener('blur', () => {
            navbar.style.transform = 'translateY(0)';
            navbar.style.opacity = '1';
        });
    });
</script>

</body>
</html>