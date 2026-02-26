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
    <title>Data Permintaan Produksi - Manajemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleDataProyekManager.css">
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
            <div class="container pt-4">
                
            <div class="header-title-wrapper">
                <div class="icon-blue-box">
                    <img src="../assets/img/data.png" alt="Icon" width="35">
                </div>
                    <h2 class="main-page-title">Data Permintaan Produksi</h2>
            </div>

                <div class="project-detail-card">
                    <h3 class="sub-title-center">Persetujuan RFQ</h3>
                    
                    <div class="info-top px-3">
                        <p><strong>ID:</strong> RFQ-011 (Proyek Pagar)</p>
                        <p><strong>Perusahaan:</strong> PT Abadi Sejahtera</p>
                        <p><strong>Material:</strong> Pagar</p>
                    </div>

                    <div class="white-info-box">
                        <p class="box-label">DATA UMUM PROYEK</p>
                        <p>Lokasi Proyek : Jl. Kawadan Industri, Cikarang</p>
                        <p>Total Panjang Pagar : Estimasi 250 Meter</p>
                        <p>Target Selesai : 45 Hari</p>
                    </div>

                    <div class="white-info-box">
                        <p class="box-label">Kriteria yang Diharapkan</p>
                        <ul class="list-unstyled">
                            <li>• Kualitas produk/jasa yang sesuai standar</li>
                            <li>• Harga kompetitif dan syarat pembayaran yang fleksibel</li>
                            <li>• Tersedia garansi 1 tahun</li>
                        </ul>
                    </div>

                    <div class="white-info-box">
                        <p class="box-label">Syarat Komersial</p>
                        <p>Mata Uang : IDR (Rupiah)</p>
                        <p>Skema Pembayaran : Termin (DP, Retensi)</p>
                        <p>Masa Retensi : 1 Bulan (5% Nilai Proyek)</p>
                    </div>

                    <div class="action-section text-center mt-4">
                        <p class="question-text">Apakah Produksi Disetujui?</p>
                        <div class="d-flex justify-content-center gap-4">
                            <button class="btn-action btn-ya">YA</button>
                            <button class="btn-action btn-tidak">TIDAK</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <nav class="bottom-nav">
            <div class="nav-item">
                <div class="active-extra-circle">
                    <a href="persetujuanProduksi.php">
                        <img src="../assets/img/berkas.png" class="nav-icon-main">
                    </a>
                </div>
            </div>

            <div class="nav-item">
                <a href="dataProyek.php"><img src="../assets/img/arsip.jpg" class="nav-icon-side"></a>
            </div>

            <div class="nav-item">
                <a href="../dashboard/manager.php">
                    <img src="../assets/img/home.png" class="nav-icon-side">
                </a>
            </div>

            <div class="nav-item">
                <a href="#"><img src="../assets/img/akun.jpg" class="nav-icon-side"></a>
            </div>
        </nav>

    </div>
</div>

</body>
</html>