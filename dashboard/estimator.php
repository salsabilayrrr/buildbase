<?php
session_start();
include "../koneksi.php";

// Proteksi Halaman
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'estimator'){
    header("Location: ../index.php");
    exit;
}

// 1. Ambil Total RFQ
$q_rfq = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_rfq");
$total_rfq = mysqli_fetch_assoc($q_rfq)['total'];

// 2. Ambil Total BOQ (Ambil dari tabel boq)
$q_boq = mysqli_query($conn, "SELECT COUNT(*) as total FROM boq");
$total_boq = mysqli_fetch_assoc($q_boq)['total'] ?? 0;

// 3. Ambil Total Shop Drawing
$q_sd = mysqli_query($conn, "SELECT COUNT(*) as total FROM shop_drawing");
$total_sd = mysqli_fetch_assoc($q_sd)['total'] ?? 0;

// 4. Query Daftar RFQ untuk Tabel
$result_rfq = mysqli_query($conn, "
    SELECT r.id_rfq, r.deskripsi, p.nama_perusahaan, r.tanggal_rfq 
    FROM data_rfq r
    JOIN pelanggan p ON r.id_pelanggan = p.id_pelanggan
    ORDER BY r.tanggal_rfq DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estimator Dashboard - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleDashboardEstimator.css">
</head>
<body>

    <header class="navbar-custom">
        <div class="flex items-center"> 
            <img src="../assets/img/logo.png" alt="BuildBase" class="w-16 h-16">
            <span class="text-2xl font-black text-black tracking-tighter -ml-2">Estimator</span>
        </div>

        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle-logout">
                <i class="fa-solid fa-right-from-bracket text-black"></i>
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="mt-4">
        <h1 class="halo-text">Halo Estimator</h1>
        
        <div class="stats-grid">
            <div class="card">
                <i class="fa-solid fa-file-alt"></i>
                <p>Total RFQ Masuk</p>
                <span class="count"><?= $total_rfq ?></span>
            </div>
            <div class="card">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <p>Total BOQ Dibuat</p>
                <span class="count"><?= $total_boq ?></span>
            </div>
            <div class="card col-span-2">
                <i class="fa-solid fa-file-signature"></i>
                <p>Total Shop Drawing Masuk</p>
                <span class="count"><?= $total_sd ?></span>
            </div>
        </div>

        <div class="px-5 mb-4">
            <div class="bg-[#C2C7FF] flex items-center px-4 py-2 rounded-2xl border-2 border-black">
                <input type="text" id="searchInput" placeholder="Cari Proyek/Klien..." class="bg-transparent w-full outline-none font-bold placeholder-gray-700">
                <i class="fa-solid fa-magnifying-glass text-white text-xl"></i>
            </div>
        </div>

        <div class="table-wrapper">
            <table id="rfqTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Proyek</th>
                        <th>Klien</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_rfq)): ?>
                    <tr>
                        <td>RFQ-<?= sprintf("%03d", $row['id_rfq']) ?></td>
                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                        <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                        <td><?= date("d/m/Y", strtotime($row['tanggal_rfq'])) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="../estimator/verif.php" class="nav-item">
            <i class="fa-solid fa-file-circle-check"></i>
        </a>
        <a href="estimator.php" class="home-button">
            <i class="fa-solid fa-house"></i>
        </a>
        <a href="../estimator/daftarrfq.php" class="nav-item">
            <i class="fa-solid fa-clipboard-check"></i>
        </a>
        <a href="../estimator/buatboq.php" class="nav-item">
            <i class="fa-solid fa-calculator"></i>
        </a>
    </nav>

    <script>
        const searchInput = document.getElementById('searchInput');
        const rfqTable = document.getElementById('rfqTable').getElementsByTagName('tbody')[0];
        const navbar = document.getElementById('navbar');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            const rows = rfqTable.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const text = rows[i].textContent.toLowerCase();
                rows[i].style.display = text.includes(filter) ? '' : 'none';
            }
        });

        // Hide navbar on focus input
        searchInput.addEventListener('focus', () => navbar.style.transform = 'translateY(100px)');
        searchInput.addEventListener('blur', () => navbar.style.transform = 'translateY(0)');
    </script>
</body>
</html>