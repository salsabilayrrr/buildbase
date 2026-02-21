<?php
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'drafter'){
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Drafter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleDashboardDrafter.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

    <header class="dashboard-header px-3">
        <div class="header-left">
            <img src="../assets/img/logo.png" class="header-logo">
            <span class="header-title">Drafter</span>
        </div>
        <a href="../logout.php" class="btn-logout-pill">
            <div class="logout-icon-box">
                <img src="../assets/img/logout.png" alt="icon">
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="scroll-content container">
    <h1 class="greeting-text">Halo Drafter</h1>

    <div class="task-container-main">
        <div class="task-header-top">
            >> DAFTAR TUGAS SHOP DRAWING
        </div>
        
        <div class="task-category-header">
            MENUNGGU REVISI (Ditolak / Perlu Perbaikan)
        </div>

        <div class="task-card">
            <div class="task-body">
                <p class="task-id">📍 ID : PROYEK-001 (Jembatan A)</p>
                <p class="task-status">Status : Belum Diperiksa</p>
                <a href="#" class="task-action">LIHAT DETAIL & UNGGAH REVISI <span class="arrow">→</span></a>
            </div>
        </div>

        <div class="task-card">
            <div class="task-body">
                <p class="task-id">📍 ID : PROYEK-003 (Gedung B)</p>
                <p class="task-status">Status : Revisi dari Pelanggan (v1.0)</p>
                <p class="task-note">Catatan : "Pelanggan minta tambah 1 jendela"</p>
                <a href="#" class="task-action">LIHAT DETAIL & UNGGAH REVISI <span class="arrow">→</span></a>
            </div>
        </div>
    </div>

    <div class="task-container-main">
        <div class="task-header-top">
            TUGAS BARU ( Belum dibuat)
        </div>

        <div class="task-card">
            <div class="task-body">
                <p class="task-id">📄 ID : PROYEK-005 (Jalan Tol C)</p>
                <p class="task-status">Dari : Estimator (BoQ Final)</p>
                <a href="#" class="task-action">UNGGAH GAMBAR BARU <span class="arrow">→</span></a>
            </div>
        </div>
    </div>
</main>

    <nav class="bottom-nav-full">
        <div class="nav-item">
            <img src="../assets/img/folder.png" class="icon-nav-folder">
        </div>
        <div class="nav-item">
            <div class="nav-home-circle">
                <img src="../assets/img/home.png" class="icon-nav-home">
            </div>
        </div>
        <div class="nav-item">
            <img src="../assets/img/load.png" class="icon-nav-load">
        </div>
        <div class="nav-item">
            <img src="../assets/img/revisi.png" class="icon-nav-rev">
        </div>
    </nav>

</body>
</html>