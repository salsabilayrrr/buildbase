<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'engineer'){
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard Engineer - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleDashboardEngineer.css">
</head>
<body>

<div class="device-wrapper">
    <div class="device-screen">
        
        <header class="dashboard-header">
            <div class="header-left">
                <img src="../assets/img/logo.png" class="header-logo" alt="Logo">
                <span class="header-title">Dashboard</span>
            </div>
            <a href="../logout.php" class="btn-logout-pill">
                <div class="logout-icon-box">
                    <img src="../assets/img/logout.png" alt="Logout">
                </div>
                <span class="logout-text">Logout</span>
            </a>
        </header>

        <main class="scroll-content">
            <div class="container text-center">
                <h1 class="greeting-text">Halo Engineer</h1>
                
                <div class="search-section">
                    <div class="search-container">
                        <input type="text" id="searchInput" placeholder="Ketik Nama Dokumen..">
                        <span class="search-icon">🔍</span>
                    </div>
                    <button class="filter-btn">
                        <span class="filter-arrow">▼</span>
                    </button>
                </div>

                <div class="row g-4 justify-content-center px-2">
                    <div class="col-6">
                        <div class="doc-card">
                            <div class="doc-icon-wrapper">
                                <img src="../assets/img/dataProyek.png" class="doc-icon" alt="Doc">
                            </div>
                            <p class="doc-text">Shop Drawing Proyek Jembatan</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="doc-card">
                            <div class="doc-icon-wrapper">
                                <img src="../assets/img/dataProyek.png" class="doc-icon" alt="Doc">
                            </div>
                            <p class="doc-text">Shop Drawing Proyek Gedung</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="doc-card">
                            <div class="doc-icon-wrapper">
                                <img src="../assets/img/dataProyek.png" class="doc-icon" alt="Doc">
                            </div>
                            <p class="doc-text">Shop Drawing Proyek Pintu Kaca</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="doc-card">
                            <div class="doc-icon-wrapper">
                                <img src="../assets/img/dataProyek.png" class="doc-icon" alt="Doc">
                            </div>
                            <p class="doc-text">Shop Drawing Proyek Jendela</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <nav class="bottom-nav" id="mainNavbar">
            <div class="nav-item">
                <a href="#"><img src="../assets/img/validasi.png" class="nav-icon-side"></a>
            </div>
            <div class="nav-item">
                <div class="home-circle">
                    <a href="#"><img src="../assets/img/home.png" class="nav-icon-home"></a>
                </div>
            </div>
            <div class="nav-item">
                <a href="#"><img src="../assets/img/database.png" class="nav-icon-side"></a>
            </div>
        </nav>

    </div>
</div>

<script>
    const navbar = document.getElementById('mainNavbar');
    const inputs = document.querySelectorAll('input, textarea');

    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            // Sembunyikan navbar ke bawah saat mengetik
            navbar.style.transform = 'translateY(120px)';
            navbar.style.opacity = '0';
        });
        input.addEventListener('blur', () => {
            // Munculkan kembali navbar saat selesai mengetik
            navbar.style.transform = 'translateY(0)';
            navbar.style.opacity = '1';
        });
    });
</script>

</body>
</html>