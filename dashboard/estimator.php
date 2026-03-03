<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);

// Koneksi Database
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil Data RFQ + Nama Pelanggan
$query = "
    SELECT 
        data_rfq.id_rfq,
        data_rfq.nama_proyek,
        pelanggan.nama_perusahaan,
        data_rfq.tanggal_rfq
    FROM data_rfq
    JOIN pelanggan ON data_rfq.id_pelanggan = pelanggan.id_pelanggan
    ORDER BY data_rfq.tanggal_rfq DESC
";

$query_sd = "SELECT COUNT(*) as total_sd FROM shop_drawing";
$result_sd = mysqli_query($conn, $query_sd);
$data_sd = mysqli_fetch_assoc($result_sd);
$total_sd = $data_sd['total_sd'];
$result = mysqli_query($conn, $query);

// Hitung total RFQ
$total_rfq = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estimator</title>
    <link rel="stylesheet" href="../assets/css/styleDashboardEstimator.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header class="navbar-custom">
        <div class="logo-section">
            <img src="../assets/img/logo.png" alt="Logo" class="logo-img">
            <span class="logo-text">Dashboard</span>
        </div>
        <a href="index.php" class="logout-btn">
            <div class="icon-circle">
                <i class="fas fa-sign-out-alt logout-icon-fa"></i>
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="container">
        <h1 class="welcome-text">Halo Estimator</h1>
        <h2 class="section-title">Daftar Dokumen yang Masuk</h2>

        <div class="stats-grid">
            <div class="card card-purple">
                <i class="fas fa-file-alt icon-stats"></i>
                <p>Total RFQ yang masuk</p>
                <span class="count"><?= $total_rfq ?></span>
            </div>
            <div class="card card-blue">
                <i class="fas fa-file-invoice-dollar icon-stats"></i>
                <p>Total BOQ yang telah dibuat</p>
                <span class="count">36</span>
            </div>
            <div class="card card-light-blue">
                <i class="fas fa-file-signature icon-stats"></i>
                <p>Total Shop Drawing yang masuk</p>
                <span class="count"><?= $total_sd ?></span>
            </div>
        </div>

        <div class="search-container">
            <div class="search-box">
                <input type="text" placeholder="Ketik Nama Proyek/Klien...">
                <i class="fas fa-search search-icon"></i>
            </div>
            <button class="filter-btn">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Proyek</th>
                        <th>Klien</th>
                        <th>Tgl Masuk</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
            <?php
            if ($total_rfq > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    // Format ID RFQ-001
                    $id_format = "RFQ-" . str_pad($row['id_rfq'], 3, "0", STR_PAD_LEFT);

                    // Format tanggal
                    $tgl_format = date("d/m/Y", strtotime($row['tanggal_rfq']));
            ?>
                <tr>
                    <td><?= $id_format ?></td>
                    <td><?= $row['nama_proyek'] ?></td>
                    <td><?= $row['nama_perusahaan'] ?></td>
                    <td><?= $tgl_format ?></td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="4">Belum ada data RFQ</td>
                </tr>
            <?php } ?>
            </tbody>
            </table>
        </div>
    </main>

    <nav class="bottom-nav">
    
    <a href="../estimator/verif.php" class="nav-item <?= ($current_page == 'verif.php') ? 'active-side' : '' ?>">
        <img src="../assets/img/est1.png" class="nav-icon">
    </a>

    <a href="verifikasi_shop_drawing.php" class="nav-item <?= ($current_page == 'verifikasi_shop_drawing.php') ? 'active-side' : '' ?>">
        <img src="../assets/img/verifikasi.png" class="nav-icon">
    </a>

    <a href="estimator.php" class="nav-item <?= ($current_page == 'estimator.php') ? 'active-home' : '' ?>">
        <img src="../assets/img/home.png" class="nav-icon">
    </a>

    <a href="dokumen.php" class="nav-item <?= ($current_page == 'dokumen.php') ? 'active-side' : '' ?>">
        <img src="../assets/img/dokumen.png" class="nav-icon">
    </a>

</nav>
</body>
</html>