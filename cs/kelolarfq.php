<?php
// 1. Koneksi ke Database
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

// Cek Koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Logika Pencarian & Pengambilan Data
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    // Menggunakan Alias 'klien' untuk menghindari bentrok nama kolom nama_perusahaan
    $query = "SELECT data_rfq.*, pelanggan.nama_perusahaan AS klien 
              FROM data_rfq 
              JOIN pelanggan ON data_rfq.id_pelanggan = pelanggan.id_pelanggan 
              WHERE pelanggan.nama_perusahaan LIKE '%$keyword%' 
              OR data_rfq.id_rfq LIKE '%$keyword%'
              ORDER BY data_rfq.id_rfq DESC";
} else {
    $query = "SELECT data_rfq.*, pelanggan.nama_perusahaan AS klien 
              FROM data_rfq 
              JOIN pelanggan ON data_rfq.id_pelanggan = pelanggan.id_pelanggan 
              ORDER BY data_rfq.id_rfq DESC";
}

$result = mysqli_query($conn, $query);

// Error Handling Query
if (!$result) {
    die("Kesalahan Query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data RFQ - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputRFQCS.css">
    
    <style>
        /* Style Tambahan untuk UI Kelola */
        .search-container {
            position: relative;
            max-width: 400px;
            margin: 0 auto;
        }
        .search-input {
            border-radius: 50px;
            background-color: #B2B9FF;
            border: none;
            padding: 10px 20px;
            color: white;
            padding-right: 45px;
        }
        .search-input::placeholder {
            color: #f0f0f0;
            font-weight: 500;
        }
        .search-icon-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
        }
        .floating-add-btn {
            position: fixed;
            bottom: 110px;
            right: 30px;
            background-color: #B2B9FF;
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            text-decoration: none;
            color: white;
            font-size: 2.5rem;
            z-index: 99;
            transition: 0.3s;
        }
        .floating-add-btn:hover {
            background-color: #8B93FF;
            color: white;
            transform: scale(1.1);
        }
        .pagination-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            font-weight: bold;
        }
        /* Memastikan tabel putih bersih di area data */
        .custom-table td {
            background-color: white !important;
        }
    </style>
</head>
<body>

    <nav class="navbar-custom">
        <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" alt="Logo" class="ms-3 me-2"> 
            <span class="fw-black fs-4 text-dark" style="font-weight: 800;">Customer Service</span>
        </div>
        <div class="me-3">
            <a href="../index.php" class="logout-btn">
                <div class="icon-circle">
                    <i class="fa-solid fa-right-from-bracket logout-icon-fa"></i>
                </div>
                <span class="logout-text">Logout</span>
            </a>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <h2 class="text-center fw-black mb-4" style="font-weight: 900; letter-spacing: 1px; text-transform: uppercase;">
            Kelola Data Request For Quotation (RFQ)
        </h2>

        <form method="POST" action="" class="search-container mb-4">
            <input type="text" name="keyword" class="form-control search-input" placeholder="Ketik Nama Proyek/Klien..." value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit" name="cari" class="search-icon-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

        <div class="table-responsive px-2">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 35%;">Pelanggan</th>
                        <th style="width: 25%;">Tanggal</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= sprintf("%03d", $row['id_rfq']) ?></td>
                            <td><?= htmlspecialchars($row['klien']) ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tanggal_rfq'])) ?></td>
                            <td>
                                <span class="badge bg-info text-dark" style="font-size: 0.7rem;"><?= $row['status_rfq'] ?></span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="inputrfq.php?id=<?= $row['id_rfq'] ?>" class="text-dark">
                                        <i class="fa-solid fa-pen-to-square fs-5"></i>
                                    </a>
                                    <a href="hapus_rfq.php?id=<?= $row['id_rfq'] ?>" class="text-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fa-solid fa-trash fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-4 text-muted">Data tidak ditemukan di database.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-custom mb-5">
            <i class="fa-solid fa-angles-left"></i>
            <span>1 2 3 ..</span>
            <i class="fa-solid fa-angles-right"></i>
        </div>
    </div>

    <a href="inputrfq.php" class="floating-add-btn">
        <i class="fa-solid fa-plus"></i>
    </a>

    <nav class="bottom-nav">
        <a href="inputrfq.php" class="nav-item">
            <i class="fa-solid fa-file-circle-plus text-white" style="font-size: 24px;"></i>
        </a>

        <a href="kelolarfq.php" class="active-cycle">
            <i class="fa-solid fa-file-lines" style="color: #8B93FF; font-size: 30px;"></i>
        </a>

        <a href="../dashboard/cs.php" class="nav-item">
            <i class="fa-solid fa-house text-white" style="font-size: 24px;"></i>
        </a>

        <a href="status.php" class="nav-item">
            <i class="fa-solid fa-paper-plane text-white" style="font-size: 24px;"></i>
        </a>

        <a href="pelanggan.php" class="nav-item">
            <i class="fa-solid fa-users-gear text-white" style="font-size: 24px;"></i>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>