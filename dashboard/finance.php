<?php
include '../koneksi.php'; // Pastikan koneksi ke database buildbase_db sudah benar

// 1. Ambil jumlah Bill of Quantity (BoQ) baru (Status Draft atau Belum Selesai)
$q_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM boq WHERE status_boq = 'Draft'");
$boq_baru = mysqli_fetch_assoc($q_count)['total'];

// 2. Logika Pencarian Tabel
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT b.id_boq, r.deskripsi as nama_boq 
              FROM boq b 
              JOIN data_rfq r ON b.id_rfq = r.id_rfq 
              WHERE r.deskripsi LIKE '%$keyword%'";
} else {
    $query = "SELECT b.id_boq, r.deskripsi as nama_boq 
              FROM boq b 
              JOIN data_rfq r ON b.id_rfq = r.id_rfq 
              ORDER BY b.id_boq DESC";
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
    <link rel="stylesheet" href="../assets/css/styleInputRFQCS.css"> <style>
        .halo-text { font-family: 'Pacifico', cursive; color: #1e1b4b; text-align: center; margin-top: 20px; }
        .section-title { font-weight: 800; text-align: center; margin-bottom: 20px; }
        
        /* Card BoQ Baru */
        .info-card { background-color: #B2B9FF; border-radius: 30px; padding: 25px; margin-bottom: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .card-body { display: flex; align-items: center; gap: 20px; justify-content: center; }
        .card-icon { width: 100px; }
        .card-text { font-weight: 800; font-size: 1.5rem; margin: 0; }

        .search-container { position: relative; max-width: 100%; margin-bottom: 20px; display: flex; gap: 10px; }
        .search-box { position: relative; flex-grow: 1; }
        .search-box input { border-radius: 50px; background-color: #B2B9FF; border: none; padding: 12px 25px; color: white; width: 100%; }
        .search-box i { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: white; }
        .filter-btn { background-color: #B2B9FF; border-radius: 15px; width: 55px; display: flex; align-items: center; justify-content: center; color: black; border: none; }

        .custom-table th { background-color: #FFC2C2 !important; border: 1px solid #000; }
        .custom-table td { background-color: white !important; border: 1px solid #000; vertical-align: middle; }
        .pdf-icon { color: #e74c3c; font-size: 1.5rem; }
        .delete-icon { color: black; font-size: 1.5rem; cursor: pointer; }
    </style>
</head>
<body>

    <header class="navbar-custom">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="BuildBase" style="width: 40px;" class="ms-3 me-2">
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
                <input type="text" name="keyword" placeholder="Ketik Nama BoQ..." value="<?= $keyword ?>">
                <button type="submit" name="cari" style="background:none; border:none;"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <button type="button" class="filter-btn"><i class="fa-solid fa-chevron-down"></i></button>
        </form>

        <div class="table-responsive">
            <table class="custom-table text-center w-100">
                <thead>
                    <tr>
                        <th width="15%">ID</th>
                        <th width="45%">Nama BoQ</th>
                        <th width="20%">File Asli</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= sprintf("%03d", $row['id_boq']) ?></td>
                        <td class="text-start"><?= htmlspecialchars($row['nama_boq']) ?></td>
                        <td><a href="#"><i class="fa-solid fa-file-pdf pdf-icon"></i></a></td>
                        <td><a href="hapus_boq.php?id=<?= $row['id_boq'] ?>" onclick="return confirm('Hapus BoQ?')"><i class="fa-solid fa-trash-can delete-icon"></i></a></td>
                    </tr>
                    <?php endwhile; ?>
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

        <a href="../financelaporannegoisasi.php" class="nav-item">
            <i class="fa-solid fa-file-export text-white" style="font-size: 24px;"></i>
        </a>

        <a href="../finance/profile.php" class="nav-item">
            <i class="fa-solid fa-magnifying-glass-chart text-white" style="font-size: 24px;"></i>
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