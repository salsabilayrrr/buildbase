<?php
include '../koneksi.php'; // Sesuaikan dengan lokasi file koneksimu

// Logika Pencarian
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT * FROM laporan_keuangan WHERE nama_laporan LIKE '%$keyword%' ORDER BY id_laporan DESC";
} else {
    $query = "SELECT * FROM laporan_keuangan ORDER BY id_laporan DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - Finance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleLaporanKeuangan.css">
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

    <div class="container mt-5 mb-5">
        <h2 class="text-center fw-black mb-5" style="font-weight: 900;">LAPORAN KEUANGAN</h2>

        <a href="inputlaporan.php" style="text-decoration: none;">
            <div class="btn-buat-laporan">
                <i class="fa-solid fa-plus fs-3"></i>
                <span>Buat Laporan</span>
            </div>
        </a>

        <form method="POST" class="search-container">
            <div class="search-input-wrapper">
                <input type="text" name="keyword" class="form-control search-input" placeholder="Ketik Judul Laporan.." value="<?= $keyword ?>">
                <button type="submit" name="cari" class="search-icon-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <button type="button" class="filter-btn"><i class="fa-solid fa-chevron-down"></i></button>
        </form>

        <div class="table-responsive">
            <table class="custom-table text-center w-100">
                <thead>
                    <tr>
                        <th style="width: 15%;">ID</th>
                        <th style="width: 40%;">Nama Laporan</th>
                        <th style="width: 20%;">File Asli</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= sprintf("%03d", $row['id_laporan']) ?></td>
                            <td class="text-start"><?= htmlspecialchars($row['nama_laporan']) ?></td>
                            <td>
                                <a href="view_pdf.php?id=<?= $row['id_laporan'] ?>" target="_blank">
                                    <i class="fa-solid fa-file-pdf pdf-icon"></i>
                                </a>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="hapus_laporan.php?id=<?= $row['id_laporan'] ?>" class="text-dark" onclick="return confirm('Hapus laporan ini?')">
                                        <i class="fa-solid fa-trash fs-4"></i>
                                    </a>
                                    <a href="editlaporan.php?id=<?= $row['id_laporan'] ?>" class="text-dark">
                                        <i class="fa-solid fa-pen-to-square fs-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Belum ada laporan tersedia.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-custom mt-4 mb-5">
            <i class="fa-solid fa-angles-left"></i><span>1 2 3 ..</span><i class="fa-solid fa-angles-right"></i>
        </div>
    </div>

    <nav id="navbar" class="bottom-nav">
    <a href="laporankeuangan.php" class="active-cycle">
        <i class="fa-solid fa-file-invoice-dollar" style="color: #8B93FF; font-size: 30px;"></i>
    </a>

    <a href="../dashboard/finance.php" class="nav-item">
        <i class="fa-solid fa-house text-white" style="font-size: 24px;"></i>
    </a>

    <a href="riwayatnegoisasi.php" class="nav-item">
        <i class="fa-solid fa-handshake text white" style="font-size: 24px;"></i>
    </a>

    <a href="evaluasi.php" class="nav-item">
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