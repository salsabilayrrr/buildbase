<?php
include '../koneksi.php';

// 1. Ambil data Statistik (opsional untuk card atas jika ingin dinamis)
$q_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM negosiasi_harga");
$total_nego = mysqli_fetch_assoc($q_total)['total'];

// 2. Logika Pencarian
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT n.id_nego, r.deskripsi as nama_proyek, n.status_nego 
              FROM negosiasi_harga n
              JOIN boq b ON n.id_boq = b.id_boq
              JOIN data_rfq r ON b.id_rfq = r.id_rfq
              WHERE r.deskripsi LIKE '%$keyword%'
              ORDER BY n.id_nego DESC";
} else {
    $query = "SELECT n.id_nego, r.deskripsi as nama_proyek, n.status_nego 
              FROM negosiasi_harga n
              JOIN boq b ON n.id_boq = b.id_boq
              JOIN data_rfq r ON b.id_rfq = r.id_rfq
              ORDER BY n.id_nego DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Negosiasi - BuildBase Finance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputRFQCS.css">
    <style>
        .section-title { font-weight: 800; text-align: center; margin-bottom: 30px; text-transform: uppercase; }
        
        /* Info Card Style */
        .info-card { background-color: #B2B9FF; border-radius: 30px; padding: 20px; margin-bottom: 30px; }
        .card-body { display: flex; align-items: center; justify-content: center; gap: 20px; }
        .card-icon { width: 80px; height: 80px; object-fit: contain; }
        .card-text { font-weight: 800; font-size: 1.2rem; margin: 0; }

        /* Search Box */
        .search-container { position: relative; max-width: 100%; margin-bottom: 25px; display: flex; gap: 10px; }
        .search-box { position: relative; flex-grow: 1; }
        .search-box input { border-radius: 50px; background-color: #B2B9FF; border: none; padding: 12px 25px; color: white; width: 100%; }
        .search-box i { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: white; }
        .filter-btn { background-color: #B2B9FF; border-radius: 15px; width: 55px; display: flex; align-items: center; justify-content: center; color: black; border: none; }

        /* Table Style */
        .custom-table th { background-color: #FFC2C2 !important; border: 1px solid #000; padding: 12px; }
        .custom-table td { background-color: white !important; border: 1px solid #000; vertical-align: middle; padding: 10px; }
        
        .status-badge { font-weight: 700; color: #1e1b4b; }
    </style>
</head>
<body>

    <header class="navbar-custom">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="Logo" style="width: 40px;" class="ms-3 me-2">
            <span class="fw-black fs-4 text-dark" style="font-weight: 800;">Finance</span>
        </div>
        <div class="me-3">
            <a href="logout.php" class="logout-btn">
                <div class="icon-circle"><i class="fa-solid fa-right-from-bracket logout-icon-fa"></i></div>
                <span class="logout-text">Logout</span>
            </a>
        </div>
    </header>

    <main class="container mt-4 mb-5">
        <h2 class="section-title">Riwayat Negosiasi Harga</h2>

        <div class="info-card">
            <div class="card-body">
                <img src="https://cdn-icons-png.flaticon.com/512/3281/3281306.png" alt="Icon Nego" class="card-icon">
                <p class="card-text"><?= $total_nego ?> Total Negosiasi Harga</p>
            </div>
        </div>

        <form method="POST" class="search-container">
            <div class="search-box">
                <input type="text" name="keyword" placeholder="Ketik Nama Proyek..." value="<?= $keyword ?>">
                <button type="submit" name="cari" style="background:none; border:none;"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <button type="button" class="filter-btn"><i class="fa-solid fa-chevron-down"></i></button>
        </form>

        <div class="table-responsive">
            <table class="custom-table text-center w-100">
                <thead>
                    <tr>
                        <th width="15%">ID</th>
                        <th width="50%">Nama Proyek</th>
                        <th width="35%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>N-<?= sprintf("%03d", $row['id_nego']) ?></td>
                            <td class="text-start"><?= htmlspecialchars($row['nama_proyek']) ?></td>
                            <td><span class="status-badge">[ <?= $row['status_nego'] ?> ]</span></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3">Tidak ada riwayat negosiasi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-custom mt-4 mb-5 text-center fw-bold">
            <i class="fa-solid fa-angles-left"></i> 1 2 3 .. <i class="fa-solid fa-angles-right"></i>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="laporankeuangan.php" class="nav-item">
            <i class="fa-solid fa-file-invoice-dollar text-white" style="font-size: 24px;"></i>
        </a>

        <a href="../dashboard/finance.php" class="nav-item">
            <i class="fa-solid fa-house text-white" style="font-size: 24px;"></i>
        </a>

        <a href="riwayatnegoisasi.php" class="active-cycle">
            <i class="fa-solid fa-handshake" style="color: #8B93FF; font-size: 30px;"></i>
        </a>

        <a href="evaluasi.php" class="nav-item">
            <i class="fa-solid fa-shield-halved text-white" style="font-size: 24px;"></i>
        </a>
    </nav>

    <script>
        const navbar = document.getElementById('navbar');
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => { navbar.style.transform = 'translateY(100px)'; });
            input.addEventListener('blur', () => { navbar.style.transform = 'translateY(0)'; });
        });
    </script>
</body>
</html>