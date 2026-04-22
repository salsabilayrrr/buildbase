<?php
include '../koneksi.php';
session_start();

// Ambil ID BoQ
$id_boq = isset($_GET['id_boq']) ? mysqli_real_escape_string($conn, $_GET['id_boq']) : '';

// 1. Ambil Informasi Dasar Proyek dari Database
$query_proyek = mysqli_query($conn, "SELECT r.deskripsi 
                                     FROM boq b 
                                     JOIN data_rfq r ON b.id_rfq = r.id_rfq 
                                     WHERE b.id_boq = '$id_boq'");
$data_p = mysqli_fetch_assoc($query_proyek);

// 2. Ambil Rincian Material yang baru diinput (Data dari Halaman Input Laporan sebelumnya)
// Kita asumsikan data dilempar melalui session atau kita tarik yang terbaru dari database
$query_detail = mysqli_query($conn, "SELECT * FROM detail_boq WHERE id_boq = '$id_boq'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Negosiasi - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputRFQCS.css">
    <style>
        .main-card { background-color: #C2C7FF; border-radius: 40px; padding: 30px; }
        .detail-nego-box { 
            background-color: white; border-radius: 25px; padding: 20px; margin-bottom: 25px;
        }
        .table-mini { font-size: 0.85rem; width: 100%; border-collapse: collapse; }
        .table-mini th { border-bottom: 2px solid #eee; padding-bottom: 8px; text-align: left; }
        .table-mini td { padding: 8px 0; border-bottom: 1px solid #fafafa; }
        
        .input-instruksi {
            width: 100%; border-radius: 20px; border: none; padding: 20px;
            min-height: 150px; font-weight: 600; font-size: 1rem;
        }
        .btn-kirim-cs {
            background-color: #1e1b4b; color: white; border-radius: 50px;
            padding: 12px 35px; border: none; font-weight: 800; transition: 0.3s;
        }
        .btn-kirim-cs:hover { background-color: #5c7cfa; transform: scale(1.05); }
    </style>
</head>
<body>

    <nav class="navbar-custom">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="Logo" style="width: 40px;" class="ms-3 me-2"> 
            <span class="fw-black fs-4 text-dark" style="font-weight: 800;">Finance</span>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <h2 class="text-center fw-black mb-4" style="font-weight: 900;">INPUT NEGOSIASI HARGA</h2>

        <div class="main-card">
            <form action="proses_negoisasi.php" method="POST">
                <input type="hidden" name="id_boq" value="<?= $id_boq ?>">

                <h5 class="fw-bold mb-3">DETAIL PROYEK (HASIL EVALUASI)</h5>
                <div class="detail-nego-box">
                    <p class="mb-2"><strong>Nama Proyek:</strong> <?= $data_p['deskripsi'] ?? 'Proyek Tidak Ditemukan' ?></p>
                    
                    <table class="table-mini">
                        <thead>
                            <tr>
                                <th>Item Material</th>
                                <th>Qty</th>
                                <th>Total Estimasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grand_total = 0;
                            while($row = mysqli_fetch_assoc($query_detail)): 
                                $grand_total += $row['subtotal'];
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama_item'] ?? 'Item Tanpa Nama') ?></td>
                                <td><?= $row['jumlah'] ?></td>
                                <td>Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                            <?php endwhile; ?>
                            
                            <tr style="border-top: 2px solid #eee;">
                                <td colspan="2" class="pt-2"><strong>Total Biaya Evaluasi:</strong></td>
                                <td class="pt-2"><strong>Rp <?= number_format($grand_total, 0, ',', '.') ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="fw-bold mb-3">INSTRUKSI NEGOSIASI UNTUK CS</h5>
                <textarea name="pesan_nego" class="input-instruksi mb-4" placeholder="Contoh: Tolong negosiasikan harga material semen agar turun 5% dari harga estimasi..." required></textarea>

                <div class="d-flex justify-content-end">
                    <button type="submit" name="kirim_nego" class="btn-kirim-cs">Kirim ke Customer Service</button>
                </div>
            </form>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="laporankeuangan.php" class="nav-item"><i class="fa-solid fa-file-invoice-dollar text-white"></i></a>
        <a href="dashboard_finance.php" class="nav-item"><i class="fa-solid fa-house text-white"></i></a>
        <a href="riwayatnegoisasi.php" class="active-cycle"><i class="fa-solid fa-handshake" style="color: #8B93FF;"></i></a>
        <a href="evaluasi.php" class="nav-item"><i class="fa-solid fa-shield-halved text-white" style="font-size: 24px;"></i></a>
    </nav>
    <script>
        const navbar = document.getElementById('navbar');
        const inputs = document.querySelectorAll('input');

        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                navbar.style.transform = 'translateY(100px)';
            });
            input.addEventListener('blur', () => {
                navbar.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>