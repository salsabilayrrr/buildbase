<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);

// Koneksi Database
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query mengambil data RFQ sesuai struktur database Anda
// Menggunakan deskripsi sebagai pengganti nama proyek
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

// Fungsi pembantu format tanggal Indonesia
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
    <title>Daftar RFQ Masuk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* CSS Utama Sesuai Gambar */
        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            padding-bottom: 100px;
        }

        .navbar-custom {
            background-color: #8B93FF;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo-section { display: flex; align-items: center; }
        .logo-img { width: 50px; height: auto; }
        .logo-text { font-size: 24px; font-weight: 800; margin-left: 10px; }

        .logout-btn {
            display: flex; align-items: center;
            text-decoration: none; background: white;
            padding: 5px 15px 5px 5px; border-radius: 50px;
        }
        .icon-circle {
            background-color: #5c7cfa; width: 35px; height: 35px;
            border-radius: 50%; display: flex; justify-content: center;
            align-items: center; margin-right: 10px;
        }
        .logout-text { color: black; font-weight: 700; font-size: 14px; }

        .container { padding: 20px; text-align: center; }
        .page-title { font-weight: 800; font-size: 24px; margin: 20px 0; }

        /* Search Bar */
        .search-container { display: flex; gap: 10px; margin-bottom: 30px; }
        .search-box { flex: 1; position: relative; }
        .search-box input {
            width: 100%; padding: 12px 20px; border-radius: 30px;
            border: none; background-color: #B1B9F7; color: white; font-weight: 600;
        }
        .search-box input::placeholder { color: rgba(255, 255, 255, 0.8); }
        .search-icon { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: white; }
        .filter-btn { background-color: #B1B9F7; border: 1px solid #000; border-radius: 10px; padding: 0 15px; }

        /* Card List */
        .rfq-list { display: flex; flex-direction: column; gap: 20px; }
        .rfq-card {
            background-color: #C0C5F8; border-radius: 20px;
            padding: 20px; text-align: left; box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            display: flex; align-items: center; gap: 10px;
            border-bottom: 1.5px solid #000; padding-bottom: 5px;
            width: fit-content; margin-bottom: 15px;
        }
        .card-header h3 { margin: 0; font-size: 16px; font-weight: 700; }
        .card-body p {
            margin: 8px 0; font-weight: 600; font-size: 14px;
            border-bottom: 1.5px solid #000; width: fit-content;
        }
        .card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }
        .btn-action {
            text-decoration: none; color: black; font-weight: 700;
            border-bottom: 2px solid #000; display: flex; align-items: center; gap: 8px;
        }
        .btn-add-note {
            background-color: #B2A59B; border: none; width: 45px; height: 35px;
            border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center;
        }

        .pagination { margin-top: 20px; font-weight: 800; display: flex; justify-content: center; gap: 10px; }

        /* Bottom Nav */
        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0;
            background: linear-gradient(to top, #8389f7, #a2a7fb);
            height: 70px; display: flex; justify-content: center; gap: 40px;
            align-items: center; z-index: 1000;
        }
        .nav-item img { width: 30px; }
        .active-home {
            background: #4a148c; width: 60px; height: 60px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 4px solid #8389f7; margin-top: -40px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .active-home {
        background: rgb(95, 22, 147);
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4a54f1 !important;
        border: 5px solid #8389f7;
        margin-top: -50px; /* Efek menonjol */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        /* Pastikan z-index tinggi agar lingkaran tidak terpotong */
        z-index: 10000; 
    }
    </style>
</head>
<body>

    <header class="navbar-custom">
        <div class="logo-section">
            <img src="../assets/img/logo.png" alt="" class="logo-img">
            <span class="logo-text">Estimator</span>
        </div>
        <a href="../index.php" class="logout-btn">
            <div class="icon-circle"><i class="fas fa-sign-out-alt"></i></div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="container">
        <h1 class="page-title">Daftar RFQ Masuk</h1>

        <div class="search-container">
            <div class="search-box">
                <input type="text" placeholder="Ketik Nama RFQ...">
                <i class="fas fa-search search-icon"></i>
            </div>
            <button class="filter-btn"><i class="fas fa-chevron-down"></i></button>
        </div>

        <div class="rfq-list">
            <?php if ($total_rfq > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="rfq-card">
                        <div class="card-header">
                            <i class="far fa-file-alt" style="font-size: 20px;"></i>
                            <h3>ID RFQ-<?= str_pad($row['id_rfq'], 3, "0", STR_PAD_LEFT) ?> (<?= $row['status_rfq'] ?>)</h3>
                        </div>
                        <div class="card-body">
                            <p>Masuk : <?= formatTanggalIndo($row['tanggal_rfq']) ?></p>
                            <p>Proyek : <?= $row['deskripsi'] ?> (<?= $row['nama_perusahaan'] ?>)</p>
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
                <p>Belum ada RFQ masuk dari Customer Service.</p>
            <?php endif; ?>
        </div>
    </main>

    <nav class="bottom-nav">
    
    <a href="../estimator/verif.php" class="nav-item <?= ($current_page == 'verif.php') ? 'active-side' : '' ?>">
        <img src="../assets/img/est1.png" class="nav-icon">
    </a>

    <a href="estimator.php" class="nav-item <?= ($current_page == 'estimator.php') ? 'active-side' : '' ?>">
        <img src="../assets/img/home.png" class="nav-icon">
    </a>

    <a href="../estimator/daftarrfq.php" class="nav-item <?= ($current_page == '../estimator/daftarrfq.php') ? 'active-side' : '' ?>">
        <img src="../assets/img/est2.png" class="nav-icon">
    </a>

    <a href="../estimator/buatboq.php" class="nav-item <?= ($current_page == '../estimator/buatboq.php') ? 'active-home' : '' ?>">
        <img src="../assets/img/est3.png" class="nav-icon">
    </a>

</body>
</html>