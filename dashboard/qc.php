<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard QC - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/styleDashboardQc.css">
</head>
<body>

<div class="app-container">
    <nav class="navbar top-bar px-3">
        <div class="d-flex align-items-center w-100 justify-content-between">
            <div class="d-flex align-items-center">
                <img src="../../assets/img/logo.jpg" class="logo-small me-2">
                <span class="role-title">Dashboard</span>
            </div>
            <a href="../../logout.php" class="logout-pill">
                <img src="../../assets/img/logout_icon.png" width="20"> Logout
            </a>
        </div>
    </nav>

    <main class="content-area p-4">
        <div class="text-center mb-4">
            <img src="../../assets/img/doc.png" width="80" class="mb-2">
            <h4 class="title-main">Input Laporan Inspeksi<br>Produksi</h4>
        </div>

        <div class="d-grid mt-5">
            <a href="input_qc.php" class="btn-start-report">
                Mulai Buat Laporan
            </a>
        </div>
    </main>

    <footer class="footer-nav">
        <div class="footer-content">
            <a href="qc.php" class="footer-item active">
                <img src="../../assets/img/home.png" class="footer-icon">
            </a>
            <div class="floating-nav-wrapper">
                <a href="dokumenQc.php" class="nav-circle">
                    <img src="../../assets/img/doc_white.png" width="30">
                </a>
            </div>
            <a href="dokumenQc.php" class="footer-item">
                <img src="../../assets/img/folder.png" class="footer-icon">
            </a>
        </div>
    </footer>
</div>

</body>
</html>