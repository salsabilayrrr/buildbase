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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleDashboardEngineer.css">
</head>
<body>

<div class="device-wrapper">
    <header class="dashboard-header">
        <div class="header-left">
            <img src="../assets/img/logo.png" class="header-logo" alt="Logo">
            <span class="header-title">Engineer</span>
        </div>
        <a href="../logout.php" class="btn-logout-pill">
            <div class="logout-icon-box"><i class="fa-solid fa-right-from-bracket"></i></div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="scroll-content">
        <div class="container">
            <h1 class="greeting-text">Halo Engineer</h1>
            
            <div class="search-section">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Ketik Nama Dokumen..">
                    <span style="font-size: 18px;">🔍</span>
                </div>
            </div>

            <div class="row g-3 px-3" id="projectList">
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                <div class="col-6 project-item">
                    <a href="../engineer/validasi.php?id=<?= $row['id_drawing'] ?>" style="text-decoration: none;">
                        <div class="doc-card">
                            <img src="../assets/img/dataProyek.png" class="doc-icon" alt="Doc">
                            <p class="doc-text">Shop Drawing <?= htmlspecialchars($row['nama_proyek']) ?></p>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    <nav class="bottom-nav">
        <div class="nav-item">
            <a href="../engineer/validasi.php"><i class="fa-solid fa-file-circle-check"></i></a>
        </div>
        <div class="nav-item">
            <div class="home-circle">
                <i class="fa-solid fa-house"></i>
            </div>
        </div>
        <div class="nav-item">
            <a href="../engineer/database.php"><i class="fa-solid fa-file-signature"></i></a>
        </div>
    </nav>
</div>

<script>
    // Pencarian Real-time
    const searchInput = document.getElementById('searchInput');
    const projectItems = document.querySelectorAll('.project-item');

    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase();
        projectItems.forEach(item => {
            const text = item.querySelector('.doc-text').textContent.toLowerCase();
            item.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

</body>
</html>