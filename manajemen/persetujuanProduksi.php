<?php
session_start();
include "../koneksi.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager'){
    header("Location: ../index.php");
    exit;
}

$status_rfq_011 = isset($_SESSION['status_rfq_011']) ? $_SESSION['status_rfq_011'] : 'Menunggu Persetujuan';
$status_rfq_012 = isset($_SESSION['status_rfq_012']) ? $_SESSION['status_rfq_012'] : 'Menunggu Persetujuan';
$status_rfq_014 = isset($_SESSION['status_rfq_014']) ? $_SESSION['status_rfq_014'] : 'Menunggu Persetujuan';

$status_class_011 = "text-warning"; 
if($status_rfq_011 == 'Disetujui') $status_class_011 = "text-success";
if($status_rfq_011 == 'Tidak Disetujui') $status_class_011 = "text-danger";

$status_class_012 = "text-warning"; 
if($status_rfq_012 == 'Disetujui') $status_class_012 = "text-success";
if($status_rfq_012 == 'Tidak Disetujui') $status_class_012 = "text-danger";

$status_class_014 = "text-warning";
if($status_rfq_014 == 'Disetujui') $status_class_014 = "text-success";
if($status_rfq_014 == 'Tidak Disetujui') $status_class_014 = "text-danger";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Produksi - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylePersetujuanProduksiManager.css">
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
            <div class="container text-center pt-3">
                <div class="top-icon-container">
                    <img src="../assets/img/produksi.png" class="main-top-icon">
                </div>

                <div class="main-approval-card">
                    <h2 class="page-title">Persetujuan Produksi</h2>

                    <div class="approval-list">
                    <div class="approval-card-item">
                        <p class="label-type">Persetujuan RFQ</p>
                        <p class="label-id">ID: RFQ-014 (Proyek Pintu Kaca)</p>
                        <div class="divider"></div>
                        <div class="card-footer-item">
                            <span class="status-text" style="color: #000 !important; font-weight: bold;">
                                Status : <?php echo $status_rfq_014; ?>
                            </span>
                            <a href="dataProyekKaca.php" class="btn-detail">Lihat Detail</a>
                        </div>
                    </div>

                    <div class="approval-card-item">
                        <p class="label-type">Persetujuan RFQ</p>
                        <p class="label-id">ID: RFQ-012 (Proyek Ventilasi Kaca)</p>
                        <div class="divider"></div>
                        <div class="card-footer-item">
                            <span class="status-text" style="color: #000 !important; font-weight: bold;">
                                Status : <?php echo $status_rfq_012; ?>
                            </span>
                            <a href="dataProyekVentilasi.php" class="btn-detail">Lihat Detail</a>
                        </div>
                    </div>

                        <div class="approval-card-item">
                            <p class="label-type">Persetujuan RFQ</p>
                            <p class="label-id">ID: RFQ-011 (Proyek Pagar)</p>
                            <div class="divider"></div>
                            <div class="card-footer-item">
                            <span class="status-text" style="color: #000 !important; font-weight: bold;">
                                Status : <?php echo $status_rfq_011; ?>
                            </span>
                                    <a href="dataProyek.php" class="btn-detail">Lihat Detail</a>
                            </div>
                        </div>
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
                <a href="../manajemen/kelolaPengguna.php">
                    <img src="../assets/img/akun.jpg" class="nav-icon-side">
                </a>
            </div>
        </nav>

    </div>
</div>

</body>
</html>