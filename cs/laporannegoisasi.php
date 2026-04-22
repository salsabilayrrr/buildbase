<?php
include '../koneksi.php';

// 1. Hitung Statistik untuk Card Atas
// Hitung total proses negosiasi (semua data di tabel negosiasi_harga)
$q_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM negosiasi_harga");
$total_proses = mysqli_fetch_assoc($q_total)['total'];

// Hitung laporan baru (status Pending)
$q_baru = mysqli_query($conn, "SELECT COUNT(*) as baru FROM negosiasi_harga WHERE status_nego = 'Pending'");
$total_baru = mysqli_fetch_assoc($q_baru)['baru'];

// 2. Logika Pencarian Tabel
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT n.id_nego, r.deskripsi as nama_proyek, p.isi_pesan as detail 
              FROM negosiasi_harga n
              JOIN boq b ON n.id_boq = b.id_boq
              JOIN data_rfq r ON b.id_rfq = r.id_rfq
              LEFT JOIN pesan_negosiasi p ON n.id_boq = p.id_boq
              WHERE r.deskripsi LIKE '%$keyword%'
              GROUP BY n.id_nego
              ORDER BY n.id_nego DESC";
} else {
    $query = "SELECT n.id_nego, r.deskripsi as nama_proyek, p.isi_pesan as detail 
              FROM negosiasi_harga n
              JOIN boq b ON n.id_boq = b.id_boq
              JOIN data_rfq r ON b.id_rfq = r.id_rfq
              LEFT JOIN (SELECT id_boq, isi_pesan FROM pesan_negosiasi ORDER BY waktu_kirim DESC LIMIT 1) p ON n.id_boq = p.id_boq
              ORDER BY n.id_nego DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Negosiasi - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleLaporanNegoisasi.css">       
</head>
<body>

    <header class="navbar-custom">
    <div class="navbar-left"> 
        <img src="../assets/img/logo.png" alt="BuildBase" class="logo-img">
        <span class="navbar-brand-text">Customer Service</span>
    </div>

    <a href="../logout.php" class="logout-btn">
        <div class="icon-circle">
            <i class="fa-solid fa-right-from-bracket logout-icon-fa"></i>
        </div>
        <span class="logout-text">Logout</span>
    </a>
    </header>

    <div class="container mt-4 mb-5">
        <h2 class="text-center fw-black mb-4" style="font-weight: 900; text-transform: uppercase;">Laporan Negosiasi Harga Dari Finance</h2>

        <form method="POST" class="search-container mb-4">
            <input type="text" name="keyword" class="form-control search-input" placeholder="Ketik Nama Proyek/Klien..." value="<?= $keyword ?>">
            <button type="submit" name="cari" class="search-icon-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <div class="row g-3 mb-5 justify-content-center">
            <div class="col-6 col-md-4">
                <div class="card-nego">
                    <img src="https://cdn-icons-png.flaticon.com/512/3281/3281306.png" alt="Shake">
                    <p><?= $total_proses ?> Proses Negoisasi</p>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card-nego">
                    <img src="https://cdn-icons-png.flaticon.com/512/2462/2462719.png" alt="Chat">
                    <p><?= $total_baru ?> Laporan Negoisasi Baru</p>
                </div>
            </div>
        </div>

        <div class="table-responsive px-2">
            <table class="custom-table text-center w-100">
                <thead>
                    <tr>
                        <th style="width: 15%;">ID</th>
                        <th style="width: 35%;">Nama Proyek</th>
                        <th style="width: 50%;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>N-<?= sprintf("%03d", $row['id_nego']) ?></td>
                            <td><?= htmlspecialchars($row['nama_proyek']) ?></td>
                            <td class="text-start"><?= $row['detail'] ? htmlspecialchars(substr($row['detail'], 0, 50)).'...' : 'Belum ada pesan' ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3">Tidak ada data negosiasi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-custom mb-5">
            <i class="fa-solid fa-angles-left"></i><span>1 2 3 ..</span><i class="fa-solid fa-angles-right"></i>
        </div>
    </div>

    <nav id="navbar" class="bottom-nav">
        <a href="inputrfq.php" class="nav-item"><i class="fa-solid fa-file-circle-check text-white" style="font-size: 24px;"></i></a>
        <a href="kelolarfq.php" class="nav-item"><i class="fa-solid fa-file-lines text-white" style="font-size: 24px;"></i></a>
        <a href="../dashboard/cs.php" class="nav-item"><i class="fa-solid fa-house text-white" style="font-size: 24px;"></i></a>
        
        <a href="laporannegoisasi.php" class="active-cycle">
            <i class="fa-solid fa-handshake" style="color: #8B93FF; font-size: 30px;"></i>
        </a>
        
        <a href="dataklien.php" class="nav-item"><i class="fa-solid fa-user-group text-white" style="font-size: 24px;"></i></a>
    </nav>

</body>
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
</html>