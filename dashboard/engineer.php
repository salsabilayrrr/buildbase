<?php
session_start();
include "../koneksi.php";

// Proteksi halaman
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'engineer'){
    header("Location: ../index.php");
    exit;
}

// Ambil data dinamis dari database
$query = mysqli_query($conn, "SELECT s.id_drawing, r.deskripsi as nama_proyek 
                              FROM shop_drawing s 
                              JOIN data_rfq r ON s.id_rfq = r.id_rfq 
                              ORDER BY s.id_drawing DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard Engineer - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleDashboardEngineer.css">
</head>
<body>

    <header class="navbar-custom">
        <div class="flex items-center"> 
            <img src="../assets/img/logo.png" alt="BuildBase" class="w-16 h-16">
            <span class="text-2xl font-black text-black tracking-tighter -ml-2">Engineer</span>
        </div>

        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle">
                <i class="fa-solid fa-right-from-bracket logout-icon-fa"></i>
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="p-4">
        <h1 class="greeting-text text-3xl mt-4 mb-6">Halo Engineer</h1>
        
        <div class="search-section mb-8">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Ketik Nama Dokumen..">
                <i class="fa-solid fa-magnifying-glass text-white text-xl ms-2"></i>
            </div>
        </div>

        <div class="row g-3" id="projectList">
            <?php while($row = mysqli_fetch_assoc($query)): ?>
            <div class="col-6 project-item">
                <a href="../engineer/validasi.php?id=<?= $row['id_drawing'] ?>" class="block no-underline">
                    <div class="doc-card">
                        <div class="flex justify-center">
                            <img src="../assets/img/dataProyek.png" class="w-16 h-16" alt="Doc">
                        </div>
                        <p class="doc-text uppercase">Shop Drawing <?= htmlspecialchars($row['nama_proyek']) ?></p>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="../engineer/validasi.php" class="nav-item">
            <i class="fa-solid fa-file-circle-check text-white text-2xl"></i>
        </a>

        <a href="dashboard.php" class="home-button">
            <i class="fa-solid fa-house text-[#8B93FF] text-3xl"></i>
        </a>

        <a href="../engineer/database.php" class="nav-item">
            <i class="fa-solid fa-file-signature text-white text-2xl"></i>
        </a>
    </nav>

    <script>
        // Pencarian Real-time
        const searchInput = document.getElementById('searchInput');
        const projectItems = document.querySelectorAll('.project-item');
        const navbar = document.getElementById('navbar');

        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            projectItems.forEach(item => {
                const text = item.querySelector('.doc-text').textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "" : "none";
            });
        });

        // Hide Navbar on Focus
        searchInput.addEventListener('focus', () => {
            navbar.style.transform = 'translateY(100px)';
        });
        searchInput.addEventListener('blur', () => {
            navbar.style.transform = 'translateY(0)';
        });
    </script>

</body>
</html>