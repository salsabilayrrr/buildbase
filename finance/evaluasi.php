<?php
session_start();
include '../koneksi.php';

// Ambil ID BoQ dari URL (misal: evaluasi_boq.php?id=5)
$id_boq = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if (empty($id_boq)) {
    header("Location: dashboard_finance.php");
    exit;
}

// 1. Ambil Informasi Header Proyek
$query_header = "SELECT b.id_boq, r.deskripsi as nama_proyek, p.nama_perusahaan, b.status_boq 
                 FROM boq b 
                 JOIN data_rfq r ON b.id_rfq = r.id_rfq 
                 JOIN pelanggan p ON r.id_pelanggan = p.id_pelanggan
                 WHERE b.id_boq = '$id_boq'";
$res_header = mysqli_query($conn, $query_header);
$header = mysqli_fetch_assoc($res_header);

// 2. Ambil Rincian Estimasi Biaya (Material)
// Asumsi ada tabel detail_boq yang menyimpan rincian barang
$query_detail = "SELECT * FROM detail_boq WHERE id_boq = '$id_boq'";
$result_detail = mysqli_query($conn, $query_detail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildBase - Evaluasi BoQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleEvaluasiBoQ.css">
</head>
<body>

    <header class="navbar-custom">
        <div class="navbar-left"> 
            <img src="../assets/img/logo.png" alt="BuildBase" class="logo-img">
            <span class="navbar-brand-text">Finance</span>
        </div>
        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle"><i class="fa-solid fa-right-from-bracket"></i></div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="p-6">
        <h1 class="page-title text-center uppercase">Evaluasi & Persetujuan<br>Bill of Quantity</h1>

        <div class="main-card-container mt-6">
            <div class="info-box-white">
                <p><strong>Proyek:</strong> <?= $header['nama_proyek'] ?> (<?= $header['nama_perusahaan'] ?>)</p>
                <p><strong>ID BoQ:</strong> BOQ-<?= str_pad($header['id_boq'], 3, "0", STR_PAD_LEFT) ?> (Dari: Estimator)</p>
                <p><strong>Status:</strong> [ <?= $header['status_boq'] ?> ]</p>
            </div>

            <h3 class="section-subtitle mt-4">RINCIAN ESTIMASI BIAYA</h3>
            
            <div class="table-responsive mt-2">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_total = 0;
                        while($row = mysqli_fetch_assoc($result_detail)): 
                            $total_per_item = $row['qty'] * $row['harga_satuan'];
                            $grand_total += $total_per_item;
                        ?>
                        <tr>
                            <td class="text-left"><?= $row['nama_material'] ?></td>
                            <td><?= $row['qty'] ?></td>
                            <td><?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                            <td><?= number_format($total_per_item, 0, ',', '.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="decision-panel mt-4">
                <p class="panel-label">PANEL KEPUTUSAN</p>
                <p class="catatan-label">Catatan Evaluasi (Internal):</p>
                <textarea class="note-area" placeholder="Contoh: Harga besi terlalu tinggi, potensi nego..."></textarea>
            </div>

            <div class="action-group mt-6">
                <p class="aksi-label">AKSI</p>
                <form action="proses_keputusan.php" method="POST">
                    <input type="hidden" name="id_boq" value="<?= $id_boq ?>">
                    <button type="submit" name="aksi" value="nego" class="btn-action">AJUKAN NEGOSIASI</button>
                    <button type="submit" name="aksi" value="setuju" class="btn-action">REKOMENDASI SETUJU</button>
                    <button type="submit" name="aksi" value="kembalikan" class="btn-action">KEMBALIKAN KE ESTIMATOR</button>
                </form>
            </div>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="laporankeuangan.php" class="nav-item"><i class="fa-solid fa-file-invoice-dollar"></i></a>
        <a href="dashboard.php" class="nav-item"><i class="fa-solid fa-house"></i></a>
        <a href="riwayat.php" class="nav-item"><i class="fa-solid fa-file-export"></i></a>
        <a href="evaluasi_list.php" class="active-cycle"><i class="fa-solid fa-magnifying-glass-chart"></i></a>
    </nav>

</body>
</html>