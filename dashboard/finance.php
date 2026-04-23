<?php
include '../koneksi.php'; 

// 1. Ambil jumlah Bill of Quantity (BoQ) baru (Status Draft)
$q_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM boq WHERE status_boq = 'Draft'");
$boq_baru = mysqli_fetch_assoc($q_count)['total'] ?? 0;

// 2. Logika Pencarian Tabel
$keyword = "";
$base_query = "SELECT b.id_boq, r.deskripsi as nama_boq, sd.file_path 
               FROM boq b 
               JOIN data_rfq r ON b.id_rfq = r.id_rfq 
               LEFT JOIN shop_drawing sd ON r.id_rfq = sd.id_rfq";

if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = $base_query . " WHERE r.deskripsi LIKE '%$keyword%'";
} else {
    $query = $base_query . " ORDER BY b.id_boq DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildBase - Finance Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleDashboardFinance.css"> 
</head>
<body>

    <header class="navbar-custom">
        <div class="navbar-left"> 
            <img src="../assets/img/logo.png" alt="BuildBase" class="logo-img">
            <span class="navbar-brand-text">Finance</span>
        </div>

        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle">
                <i class="fa-solid fa-right-from-bracket logout-icon-fa"></i>
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="container mt-4 mb-5">
        <h1 class="halo-text">Halo Finance</h1>
        <h2 class="section-title">Bill of Quantity</h2>

        <div class="info-card text-center">
            <div class="card-body">
                <img src="../assets/img/assetfinance.png" alt="Icon" class="card-icon"> 
                <p class="card-text"><?= $boq_baru ?> Bill of Quantity Baru</p>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-2 mb-4 fw-bold">
            <i class="fa-solid fa-angles-left"></i> 1 2 3 .. <i class="fa-solid fa-angles-right"></i>
        </div>

        <form method="POST" class="search-container">
            <div class="search-box">
                <input type="text" name="keyword" placeholder="Ketik Nama BoQ..." value="<?= htmlspecialchars($keyword) ?>">
                <button type="submit" name="cari" style="background:none; border:none;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <button type="button" class="filter-btn"><i class="fa-solid fa-chevron-down"></i></button>
        </form>

        <div class="table-responsive">
            <table class="custom-table text-center w-100">
                <thead>
                    <tr>
                        <th width="15%">ID</th>
                        <th width="40%">Nama BoQ</th>
                        <th width="15%">File Asli</th>
                        <th width="30%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= sprintf("%03d", $row['id_boq']) ?></td>
                            <td class="text-start"><?= htmlspecialchars($row['nama_boq']) ?></td>
                            <td>
                                <?php if(!empty($row['file_path'])): ?>
                                    <a href="../uploads/<?= $row['file_path'] ?>" target="_blank">
                                        <i class="fa-solid fa-file-pdf text-danger fs-4"></i>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="../finance/evaluasi.php?id=<?= $row['id_boq'] ?>" 
                                   class="btn btn-sm rounded-pill px-3 shadow-sm font-bold" 
                                   style="background-color: #8B93FF; color: white;">
                                   Evaluasi & Setujui
                                </a>
                                
                                <a href="hapus_boq.php?id=<?= $row['id_boq'] ?>" class="ms-2 text-dark" onclick="return confirm('Hapus BoQ?')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-4 text-center text-muted italic">Tidak ada data Bill of Quantity.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="../finance/laporankeuangan.php" class="nav-item">
            <i class="fa-solid fa-file-invoice-dollar text-white" style="font-size: 24px;"></i>
        </a>
        <a href="finance.php" class="active-cycle">
            <i class="fa-solid fa-house" style="color: #8B93FF; font-size: 30px;"></i>
        </a>
        <a href="../finance/riwayatnegoisasi.php" class="nav-item">
            <i class="fa-solid fa-handshake text-white" style="font-size: 24px;"></i>
        </a>
        <a href="../finance/evaluasi.php" class="nav-item">
            <i class="fa-solid fa-shield-halved text-white" style="font-size: 24px;"></i>
        </a>
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