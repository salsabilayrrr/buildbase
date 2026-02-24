<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildBase - Finance Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/StyleDashboardFinance.css">
</head>
<body>

    <header class="navbar-custom">
        <div class="logo-section">
            <img src="../assets/img/logo.png" alt="BuildBase" class="logo-img">
            <span class="logo-text">BuildBase</span>
        </div>

        <a href="../index.php" class="logout-btn">
            <div class="icon-circle">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <span class="logout-label">Logout</span>
        </a>
    </header>

    <main class="content">
        <h1 class="halo-text">Halo Finance</h1>
        <h2 class="section-title">Bill of Quantity</h2>

        <div class="info-card">
            <div class="card-body">
                <img src="../assets/img/assetfinance.png" alt="Icon" class="card-icon">
                <p class="card-text">5 Bill of Quantity Baru</p>
            </div>
        </div>

        <div class="pagination">
            <i class="fa-solid fa-angles-left"></i> 1 2 3 .. <i class="fa-solid fa-angles-right"></i>
        </div>

        <div class="search-container">
            <div class="search-box">
                <input type="text" placeholder="Ketik Nama BoQ...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <button class="filter-btn">
                <i class="fa-solid fa-chevron-down"></i>
            </button>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="15%">ID</th>
                        <th width="40%">Nama BoQ</th>
                        <th width="25%">File Asli</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>Proyek Jembatan</td>
                        <td><i class="fa-solid fa-file-pdf pdf-icon"></i></td>
                        <td><i class="fa-solid fa-trash-can delete-icon"></i></td>
                    </tr>
                    <tr>
                        <td>...</td>
                        <td>...</td>
                        <td><i class="fa-solid fa-file-pdf pdf-icon"></i></td>
                        <td><i class="fa-solid fa-trash-can delete-icon"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <i class="fa-solid fa-angles-left"></i> 1 2 3 .. <i class="fa-solid fa-angles-right"></i>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <i class="fa-solid fa-file-lines nav-icon"></i>
        <div class="home-btn-container">
            <div class="home-btn">
                <i class="fa-solid fa-house"></i>
            </div>
        </div>
        <i class="fa-solid fa-file-export nav-icon"></i>
        <i class="fa-solid fa-magnifying-glass-chart nav-icon"></i>
    </nav>
    <script>
        // SCRIPT AGAR NAVBAR TENGGELAM SAAT MENGETIK
        const navbar = document.getElementById('navbar');
        const inputs = document.querySelectorAll('input');

        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                // Sembunyikan navbar (tenggelam)
                navbar.style.transform = 'translateY(100px)';
            });
            input.addEventListener('blur', () => {
                // Tampilkan kembali navbar
                navbar.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>