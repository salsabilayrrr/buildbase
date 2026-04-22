<?php
include '../koneksi.php';
session_start();

// Statistik
$q_pending = mysqli_query($conn, "SELECT COUNT(*) as total FROM shop_drawing WHERE status_verifikasi = 'Pending'");
$count_pending = mysqli_fetch_assoc($q_pending)['total'] ?? 0;

$q_valid = mysqli_query($conn, "SELECT COUNT(*) as total FROM shop_drawing WHERE status_verifikasi = 'Disetujui'");
$count_valid = mysqli_fetch_assoc($q_valid)['total'] ?? 0;

// Query Tabel
$query = "SELECT s.id_drawing, s.file_path, r.deskripsi as nama_proyek 
          FROM shop_drawing s 
          JOIN data_rfq r ON s.id_rfq = r.id_rfq 
          ORDER BY s.id_drawing DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Database Engineer - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleRiwayatEngineer.css">
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

    <main class="mt-4">
        <h1 class="text-center font-black text-2xl mb-4 uppercase tracking-tighter">Database</h1>

        <div class="stat-wrapper">
            <div class="stat-card">
                <i class="fa-regular fa-file-lines"></i>
                <p><?= $count_pending ?><br>Belum Valid</p>
            </div>
            <div class="stat-card">
                <i class="fa-regular fa-file-lines"></i>
                <p><?= $count_valid ?><br>Sudah Valid</p>
            </div>
        </div>

        <div class="table-container mb-5">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="40%">Nama</th>
                        <th width="35%">ID Drawing</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_proyek']) ?></td>
                            <td class="text-center">
                                <a href="../<?= $row['file_path'] ?>" target="_blank" class="id-drawing-pill">
                                    <i class="fa-solid fa-file-pdf"></i> DRAW-<?= sprintf("%03d", $row['id_drawing']) ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="validasi.php?id=<?= $row['id_drawing'] ?>" class="btn-validate">
                                    Validasi
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <nav class="bottom-nav">
        <a href="validasi.php" class="nav-item">
            <i class="fa-solid fa-file-circle-check text-white text-2xl"></i>
        </a>

        <a href="../dashboard/engineer.php" class="nav-item">
            <i class="fa-solid fa-house text-white text-2xl"></i>
        </a>

        <a href="database.php" class="home-button">
            <i class="fa-solid fa-file-signature text-[#8B93FF] text-3xl"></i>
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