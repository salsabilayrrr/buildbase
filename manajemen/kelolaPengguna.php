<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager'){
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Pengguna - Manajemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleKelolaPenggunaManager.css">
</head>
<body>

<div class="device-wrapper">
    <div class="device-screen">
        
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
            <div class="container text-center pt-4">
                
                <div class="header-title-container">
                    <h2 class="main-page-title">Kelola Data Pengguna</h2>
                    <div class="icon-right-box">
                        <img src="../assets/img/inputUser.png" alt="User Icon" width="40">
                    </div>
                </div>

                <div class="add-user-section mb-4">
                    <a href="inputUser.php" class="btn-add-link">
                        <img src="../assets/img/tambahUser.png" alt="Add" width="65">
                    </a>
                </div>

                <div class="search-container mb-4">
                    <input type="text" placeholder="Ketik Nama Pengguna..." class="search-input">
                    <span class="search-icon">🔍</span>
                </div>

                <h3 class="section-subtitle">Daftar Pengguna Aktif</h3>

                <div class="table-responsive px-2">
                    <table class="table table-bordered custom-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Peran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Jeno</td>
                                <td>Warehouse</td>
                                <td>
                                    <div class="action-icons">
                                        <img src="../assets/img/edit.png" alt="Edit">
                                        <img src="../assets/img/sampah.png" alt="Delete">
                                        <img src="../assets/img/key.png" alt="Key">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Haechan</td>
                                <td>Customer Service</td>
                                <td>
                                    <div class="action-icons">
                                        <img src="../assets/img/edit.png" alt="Edit">
                                        <img src="../assets/img/sampah.png" alt="Delete">
                                        <img src="../assets/img/key.png" alt="Key">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

    </div>
</div>

<script>
    // Memilih elemen footer dengan ID 'navbar'
    const footer = document.getElementById('navbar');
    // Pilih semua input (termasuk search bar)
    const inputs = document.querySelectorAll('input, textarea');

    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            // Sembunyikan footer ke bawah saat mengetik agar tidak terangkat keyboard
            if (footer) {
                footer.style.transform = 'translateY(150px)';
                footer.style.transition = 'transform 0.3s ease'; // Tambah efek halus
            }
        });
        
        input.addEventListener('blur', () => {
            // Munculkan kembali saat selesai mengetik
            if (footer) {
                footer.style.transform = 'translateY(0)';
            }
        });
    });
</script>

</body>
</html>