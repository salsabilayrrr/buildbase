<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard QC - BuildBase</title>
    <link rel="stylesheet" href="../assets/css/styleDashboardQc.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>

<div class="device-wrapper">
    <div class="device-screen">
        
        <div class="dashboard-header">
            <div class="header-left">
                <img src="../assets/img/logo.png" class="header-logo">
                <span class="header-title">Dashboard</span>
            </div>
            <a href="../logout.php" class="btn-logout-pill">
                <div class="logout-icon-box">
                    <img src="../assets/img/logout.png" alt="icon">
                </div>
                <span class="logout-text">Logout</span>
            </a>
        </div>

        <div class="scroll-content">
            <h1 class="greeting-text">Halo Quality Control</h1>
            
            <div class="search-section-wrapper">
                <img src="../assets/img/avatar.png" class="avatar-floating">
                <div class="search-container">
                    <div class="search-box">
                        <input type="text" placeholder="Ketik Nama Dokumen...">
                        <span class="search-icon">🔍</span>
                    </div>
                    <button class="btn-filter">▼</button>
                </div>
            </div>

            <div class="project-grid">
                <div class="project-card">
                    <img src="../assets/img/doc.png" class="doc-img">
                    <p>Dokumen Proyek 1</p>
                </div>
                <div class="project-card">
                    <img src="../assets/img/doc.png" class="doc-img">
                    <p>Dokumen Proyek 2</p>
                </div>
                <div class="project-card">
                    <img src="../assets/img/doc.png" class="doc-img">
                    <p>Dokumen Proyek 3</p>
                </div>
                <div class="project-card">
                    <img src="../assets/img/doc.png" class="doc-img">
                    <p>Dokumen Proyek 4</p>
                </div>
            </div>
        </div>

        <div class="bottom-nav-full">
        <div class="nav-item">
            <a href="qc.php">
                <div class="nav-home-circle">
                    <img src="../assets/img/home.png" class="icon-nav-home">
                </div>
            </a>
        </div>
            <div class="nav-item">
                <a href="../qc/dokumenQc.php">
                    <img src="../assets/img/folder.png" class="icon-nav-folder">
                </a>
            </div>
        </div>

    </div>
</div>

</body>
</html>