<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);

// Koneksi Database
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "
    SELECT 
        data_rfq.id_rfq,
        data_rfq.deskripsi,
        data_rfq.tanggal_rfq,
        data_rfq.status_rfq,
        pelanggan.nama_perusahaan
    FROM data_rfq
    JOIN pelanggan ON data_rfq.id_pelanggan = pelanggan.id_pelanggan
    ORDER BY data_rfq.tanggal_rfq DESC
";

$result = mysqli_query($conn, $query);
$total_rfq = mysqli_num_rows($result);

function formatTanggalIndo($date) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $d = date('d', strtotime($date));
    $m = (int)date('m', strtotime($date));
    $y = date('Y', strtotime($date));
    return "$d {$bulan[$m]} $y";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar RFQ Masuk - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleDaftarRFQEstimator.css">
</head>
<body>

    <header class="navbar-custom">
        <div class="flex items-center"> 
            <img src="../assets/img/logo.png" alt="BuildBase" style="width: 60px; height: auto;">
            <span class="text-2xl font-black text-black tracking-tighter -ml-2">Estimator</span>
        </div>

        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle">
                <i class="fa-solid fa-right-from-bracket text-black"></i>
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="container">
        <h1 class="page-title">Daftar RFQ Masuk</h1>

        <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari ID atau Proyek...">
                <i class="fas fa-search text-white"></i>
            </div>
        </div>

        <div class="rfq-list" id="rfqList">
            <?php if ($total_rfq > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="rfq-card">
                        <div class="card-header">
                            <i class="far fa-file-alt"></i>
                            <h3>ID RFQ-<?= str_pad($row['id_rfq'], 3, "0", STR_PAD_LEFT) ?> (<?= $row['status_rfq'] ?>)</h3>
                        </div>
                        <div class="card-body">
                            <p>Masuk : <?= formatTanggalIndo($row['tanggal_rfq']) ?></p>
                            <p>Proyek : <?= htmlspecialchars($row['deskripsi']) ?> (<?= htmlspecialchars($row['nama_perusahaan']) ?>)</p>
                        </div>
                        <div class="card-footer">
                            <a href="buatboq.php?id=<?= $row['id_rfq'] ?>" class="btn-action">
                                Pembuatan BOQ <i class="fas fa-arrow-right"></i>
                            </a>
                            <button class="btn-add-note"><i class="fas fa-file-medical"></i></button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center font-bold text-gray-500">Belum ada RFQ masuk.</p>
            <?php endif; ?>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
    <a href="verif.php" class="nav-item">
        <i class="fa-solid fa-file-circle-check"></i>
    </a>

    <a href="../dashboard/estimator.php" class="nav-item">
        <i class="fa-solid fa-house"></i>
    </a>

    <a href="daftarrfq.php" class="home-button">
        <i class="fa-solid fa-clipboard-check"></i>
    </a>

    <a href="buatboq.php" class="nav-item">
        <i class="fa-solid fa-calculator"></i>
    </a>
</nav>
    <script>
        const searchInput = document.getElementById('searchInput');
        const rfqList = document.getElementById('rfqList');
        const cards = rfqList.getElementsByClassName('rfq-card');
        const navbar = document.getElementById('navbar');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            for (let i = 0; i < cards.length; i++) {
                const text = cards[i].textContent.toLowerCase();
                cards[i].style.display = text.includes(filter) ? '' : 'none';
            }
        });

        searchInput.addEventListener('focus', () => navbar.style.transform = 'translateY(100px)');
        searchInput.addEventListener('blur', () => navbar.style.transform = 'translateY(0)');
    </script>
</body>
</html>