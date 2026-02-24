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
    <title>Dashboard Manajemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style_manajemen.css">
</head>
<body>

    <header class="dashboard-header">
        <div class="header-left">
            <img src="../assets/img/logo.png" class="header-logo" alt="Logo">
            <span class="header-title">Dashboard</span>
        </div>
        <a href="logout.php" class="btn-logout-pill">
            <div class="logout-icon-box">
                <img src="../assets/img/logout_icon.png" alt="Logout">
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="scroll-content">
        <div class="container py-4 text-center">
            <h1 class="greeting-text">Halo Manajemen</h1>
            
            <div class="char-icon-box">
                <img src="../assets/img/man_character.png" alt="Man Character" class="char-image">
            </div>

            <div class="summary-label">
                Rangkuman Aktivitas Hari Ini :
            </div>

            <div class="row g-3 justify-content-center mb-4">
                <div class="col-5">
                    <div class="stat-card">
                        <img src="../assets/img/icon_rfq.png" class="stat-icon">
                        <p class="stat-text">RFQ yang Masuk</p>
                        <p class="stat-number">5</p>
                    </div>
                </div>
                <div class="col-5">
                    <div class="stat-card">
                        <img src="../assets/img/icon_project.png" class="stat-icon">
                        <p class="stat-text">Proyek yang Sedang Dikerjakan</p>
                        <p class="stat-number">4</p>
                    </div>
                </div>
            </div>

            <div class="report-box">
                <div class="report-section">
                    <p class="report-title">Laporan Masuk Terbaru dari QC</p>
                    <p class="report-item">[ QC ] Proyek Pintu Kaca - Hasil Tes - [ LOLOS ]</p>
                    <p class="report-item">[ QC ] Proyek Ventilasi Kaca - Hasil Tes - [ Revisi ]</p>
                </div>
                <div class="report-divider"></div>
                <div class="report-section">
                    <p class="report-title">Laporan Masuk Terbaru dari Finance</p>
                    <p class="report-item">[Finance] Proyek Pintu Kaca - Hasil Negosiasi-[LOLOS]</p>
                    <p class="report-item">[Finance] Proyek Pagar - Hasil Negosiasi - [Revisi]</p>
                </div>
            </div>
        </div>
    </main>

    <nav class="bottom-nav">
        <div class="nav-item">
            <img src="../assets/img/icon_doc.png" class="nav-icon-side">
        </div>
        <div class="nav-item">
            <img src="../assets/img/icon_chat.png" class="nav-icon-side">
        </div>
        <div class="nav-item">
            <div class="home-circle">
                <img src="../assets/img/icon_home.png" class="nav-icon-home">
            </div>
        </div>
        <div class="nav-item">
            <img src="../assets/img/icon_user.png" class="nav-icon-side">
        </div>
    </nav>

</body>
</html>