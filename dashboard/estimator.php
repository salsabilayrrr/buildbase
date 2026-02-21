<?php
session_start();
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

    <header class="top-bar">
        <div class="logo-section">
            <img src="https://cdn-icons-png.flaticon.com/512/609/609803.png" alt="Logo" class="logo-img">
            <span class="logo-text">Dashboard</span>
        </div>
        <button class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </header>

    <main class="container">
        <h1 class="welcome-text">Halo Estimator</h1>
        <h2 class="section-title">Daftar Dokumen yang Masuk</h2>

        <div class="stats-grid">
            <div class="card card-purple">
                <i class="fas fa-file-alt icon-stats"></i>
                <p>Total RFQ yang masuk</p>
                <span class="count">5</span>
            </div>
            <div class="card card-blue">
                <i class="fas fa-file-invoice-dollar icon-stats"></i>
                <p>Total BOQ yang telah dibuat</p>
                <span class="count">36</span>
            </div>
            <div class="card card-light-blue">
                <i class="fas fa-file-signature icon-stats"></i>
                <p>Total Shop Drawing yang masuk</p>
                <span class="count">4</span>
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
                    <tr>
                        <td>RFQ-005</td>
                        <td>Proyek Jendela</td>
                        <td>PT. Maju</td>
                        <td>13/11/2025</td>
                    </tr>
                    <tr>
                        <td>RFQ-004</td>
                        <td>Renovasi Pintu</td>
                        <td>PT. Abadi</td>
                        <td>12/11/2025</td>
                    </tr>
                    <tr>
                        <td>RFQ-003</td>
                        <td>Proyek Ventilasi</td>
                        <td>PT. Shiyong</td>
                        <td>11/11/2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <nav class="bottom-nav">
        <div class="nav-item"><i class="fas fa-th-large"></i></div>
        <div class="nav-item active-home"><i class="fas fa-home"></i></div>
        <div class="nav-item"><i class="fas fa-file-check"></i></div>
        <div class="nav-item"><i class="fas fa-list-ul"></i></div>
    </nav>

</body>
</html>