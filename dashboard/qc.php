<?php
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'qc'){
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Quality Control</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="../assets/css/styleDashboardQc.css">
</head>

<body>

<!-- HEADER -->
<nav class="navbar navbar-expand-lg top-bar px-4">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.jpg" class="logo-small me-2" style="width: 60px !important; height: auto;">
            <span class="role-title">Quality Control</span>
        </div>

        <a href="../logout.php" class="btn btn-light btn-sm">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container py-4">

    <h3 class="hello-text text-center mb-4">
        Halo Quality Control 👋
    </h3>

    <!-- Search -->
    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Ketik Nama Dokumen..">
                <button class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Document Cards -->
    <div class="row g-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="doc-card text-center p-4">
                <i class="bi bi-file-earmark-text doc-icon mb-2"></i>
                <div>Dokumen Proyek 1</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="doc-card text-center p-4">
                <i class="bi bi-file-earmark-text doc-icon mb-2"></i>
                <div>Dokumen Proyek 2</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="doc-card text-center p-4">
                <img src="../assets/img/doc.png" class="doc-img mb-2">
                <div>Dokumen Proyek 3</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="doc-card text-center p-4">
                <img src="../assets/img/doc.png" class="doc-img mb-2">
                <div>Dokumen Proyek 4</div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer-nav">
        <div class="footer-content">

            <a href="qc.php" class="footer-item text-decoration-none">
                <img src="../assets/img/home.png" class="footer-icon footer-home">
                <div class="footer-text">Home</div>
            </a>
            <a href="../dashboard/qc/dokumenQc.php" class="footer-item text-decoration-none">
                <img src="../assets/img/folder.png" class="footer-icon">
                <div class="footer-text">Dokumen</div>
            </a>
        </div>
    </footer>

</div>

</body>
</html>
