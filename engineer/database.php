<?php
include '../koneksi.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding-bottom: 90px; /* Ruang agar konten bawah tidak tertutup navbar */
            overflow-x: hidden;
        }

        /* Navbar Top */
        .navbar-custom {
            background-color: #8B93FF;
            padding: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header-logo { width: 30px; height: 30px; margin-right: 10px; }
        .header-title { color: #000; font-weight: 800; font-size: 1.2rem; }

        .main-title { font-weight: 800; text-align: center; margin: 20px 0; font-size: 1.5rem; }

        /* Stats Card */
        .stat-wrapper { display: flex; justify-content: center; gap: 15px; padding: 0 15px; margin-bottom: 25px; }
        .stat-card {
            background-color: #C2C7FF;
            border-radius: 20px;
            width: 145px;
            height: 165px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 4px 4px 0px #000; /* Border shadow gaya gambar 2 */
            border: 1.5px solid #000;
        }
        .stat-card i { font-size: 2.5rem; color: white; margin-bottom: 10px; text-shadow: 2px 2px 0px #000; }
        .stat-card p { font-weight: 800; color: #000; margin: 0; font-size: 0.9rem; text-align: center; line-height: 1.2; }

        /* Tabel */
        .table-container { padding: 0 15px; }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            background: white;
            box-shadow: 4px 4px 0px #000;
        }
        .custom-table th {
            background-color: #C2C7FF !important;
            border: 1.5px solid #000;
            padding: 12px;
            font-weight: 800;
            text-align: center;
        }
        .custom-table td {
            border: 1.5px solid #000;
            padding: 12px;
            vertical-align: middle;
            font-weight: 700;
            background: #fff;
        }

        .id-drawing-pill {
            background: #fff;
            border: 1px solid #000;
            padding: 5px 10px;
            border-radius: 8px;
            text-decoration: none;
            color: #ff6b6b;
            font-size: 0.8rem;
            font-weight: 800;
        }

        .btn-validate {
            background: #1e1b4b;
            color: white;
            border-radius: 8px;
            padding: 8px 12px;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: bold;
            display: inline-block;
        }

        /* Bottom Nav - TIDAK NGAMBANG (Menempel ke Bawah) */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #8B93FF;
            height: 75px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 1000;
            /* Border radius hanya di atas agar menyatu dengan layar bawah */
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            box-shadow: 0 -5px 15px rgba(0,0,0,0.1);
        }

        .nav-item { color: white; font-size: 26px; text-decoration: none; }

        /* Lingkaran Aktif Paling Kanan */
        .active-cycle {
            width: 70px;
            height: 70px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 5px solid #8B93FF;
            margin-top: -45px; /* Tetap melayang sedikit dari bar tapi bar-nya nempel bawah */
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .active-cycle i { color: #8B93FF; font-size: 32px; }

    </style>
</head>
<body>

    <header class="navbar-custom">
        <img src="../assets/img/logo.png" class="header-logo" alt="Logo">
        <span class="header-title">Engineer</span>
    </header>

    <main>
        <h1 class="main-title">Database</h1>

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

        <div class="table-container">
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
        <a href="validasi.php" class="nav-item"><i class="fa-solid fa-file-circle-check"></i></a>
        <a href="../dashboard/engineer.php" class="nav-item"><i class="fa-solid fa-house"></i></a>
        <div class="active-cycle">
            <i class="fa-solid fa-file-signature"></i>
        </div>
    </nav>

</body>
</html>