<?php
session_start();
include "../koneksi.php";
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager'){
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'approve') {
        $_SESSION['status_rfq_014'] = 'Disetujui';
        header("Location: persetujuanProduksi.php");
        exit;
    } elseif ($_GET['action'] == 'reject') {
        $_SESSION['reject_data'] = [
            'perusahaan' => 'PT Kaca Indah Jaya',
            'proyek'     => 'Proyek Pintu Kaca (RFQ-014)'
        ];
        $_SESSION['status_rfq_014'] = 'Tidak Disetujui';
        header("Location: penolakan.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Permintaan Produksi - RFQ 014</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleDataProyekKacaManager.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="device-wrapper">
    <div class="device-screen">
        
        <header class="dashboard-header">
            <div class="header-left">
                <img src="../assets/img/logo.png" class="header-logo">
                <span class="header-title">Manajemen</span>
            </div>
            <a href="../logout.php" class="btn-logout-pill">
                <div class="logout-icon-box">
                    <img src="../assets/img/logout.png">
                </div>
                <span class="logout-text">Logout</span>
            </a>
        </header>

        <main class="scroll-content">
            <div class="container pt-4 pb-5">
                
                <div class="header-title-wrapper">
                    <div class="icon-blue-box">
                        <img src="../assets/img/data.png" width="35">
                    </div>
                    <h2 class="main-page-title">Data Permintaan Produksi</h2>
                </div>

                <div class="project-detail-card">
                    <h3 class="sub-title-center">Persetujuan RFQ</h3>
                    
                    <div class="info-top px-3">
                        <p><strong>ID:</strong> RFQ-014 (Proyek Pintu Kaca)</p>
                        <p><strong>Perusahaan:</strong> PT Kaca Indah Jaya</p>
                        <p><strong>Material:</strong> Pintu Kaca Tempered</p>
                    </div>

                    <div class="white-info-box">
                        <p class="box-label">DATA UMUM PROYEK</p>
                        <p>Lokasi Proyek : Jakarta Selatan</p>
                        <p>Jumlah Unit : 50 Pintu Kaca</p>
                        <p>Target Selesai : 30 Hari</p>
                    </div>

                    <div class="white-info-box">
                        <p class="box-label">Kriteria yang Diharapkan</p>
                        <ul class="list-unstyled">
                            <li>• Kaca tempered ketebalan 10mm</li>
                            <li>• Finishing rapi dan presisi tinggi</li>
                            <li>• Tahan benturan dan aman digunakan</li>
                        </ul>
                    </div>

                    <div class="white-info-box">
                        <p class="box-label">Syarat Komersial</p>
                        <p>Mata Uang : IDR (Rupiah)</p>
                        <p>Skema Pembayaran : DP 50% + Pelunasan</p>
                        <p>Masa Garansi : 6 Bulan</p>
                    </div>

                    <div class="action-section text-center mt-4">
                        <p class="question-text">Apakah Produksi Disetujui?</p>
                        <div class="d-flex justify-content-center gap-4">
                            <button class="btn-action btn-ya" id="btnYa">YA</button>
                            <button class="btn-action btn-tidak" id="btnTidak">TIDAK</button>
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
                <a href="kelolaPengguna.php">
                    <img src="../assets/img/akun.jpg" class="nav-icon-side">
                </a>
            </div>
        </nav>

    </div>
</div>

<script>
    // Konfirmasi untuk tombol YA (Setuju)
    document.getElementById('btnYa').addEventListener('click', function() {
        Swal.fire({
            title: 'Konfirmasi Setuju?',
            text: "Anda akan menyetujui permintaan produksi ini.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#8A8BFC',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'dataProyekKaca.php?action=approve';
            }
        });
    });

    // Konfirmasi untuk tombol TIDAK (Tolak)
    document.getElementById('btnTidak').addEventListener('click', function() {
    Swal.fire({
        title: 'Konfirmasi Tolak?',
        text: "Permintaan produksi ini akan ditolak.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c', 
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Ya, Tolak!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Ini akan memicu logika PHP 'reject' di atas
            window.location.href = 'dataProyekKaca.php?action=reject'; 
        }
    });
});
</script>

</body>
</html>