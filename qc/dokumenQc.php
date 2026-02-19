<?php
session_start();
// Pastikan pengecekan session dan role sudah benar
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'qc'){
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Laporan QC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/styleDokumenQc.css">
</head>
<body>

<nav class="navbar navbar-expand-lg top-bar px-3">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.jpg" class="logo-small me-2" style="width: 60px !important; height: auto;">
            <span class="role-title">Quality Control</span>
        </div>
        <a href="../logout.php" class="btn-logout-pill">
                <div class="logout-icon-box">
                    <img src="../assets/img/logout.png" alt="icon">
                </div>
                <span class="logout-text">Logout</span>
            </a>
    </div>
</nav>

<main class="main-wrapper container py-4">
    <div class="text-center mb-3">
        <img src="../assets/img/doc.png" class="doc-header-icon" style="width: 80px;">
    </div>

    <h4 class="text-center title-text mb-4">
        Input Laporan Inspeksi<br>Produksi
    </h4>

    <div class="form-card-qc p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">ID Produksi :</label>
                <input type="text" class="form-control custom-input" placeholder="PROD-2025-X">
            </div>

            <div class="mb-3">
                <label class="form-label">Hasil Pemeriksaan :</label>
                <div class="ms-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="hasil" id="lolos">
                        <label class="form-check-label" for="lolos">Lolos</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="hasil" id="revisi">
                        <label class="form-check-label" for="revisi">Gagal / Revisi</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Parameter Cek :</label>
                <div class="ms-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="c1">
                        <label class="form-check-label" for="c1">Dimensi Sesuai</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="c2">
                        <label class="form-check-label" for="c2">Kualitas Material</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="c3">
                        <label class="form-check-label" for="c3">Finishing Rapi</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan Temuan :</label>
                <input type="text" class="form-control custom-input" placeholder="Tulis Detail Catatan">
            </div>

            <div class="mb-3">
                <label class="form-label">Bukti Foto :</label>
                <input type="file" class="form-control custom-input">
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn-save-qc">Simpan Laporan</button>
            </div>
        </form>
    </div>
</main>

        <div class="bottom-nav-full">
            <div class="nav-item">
                <a href="../dashboard/qc.php">
                    <img src="../assets/img/home.png" class="icon-nav-home">
                </a>
            </div>
            <div class="nav-item">
                <div class="nav-folder-circle">
                    <img src="../assets/img/folder.png" class="icon-nav-folder">
                </div>
            </div>
        </div>

</body>
</html>