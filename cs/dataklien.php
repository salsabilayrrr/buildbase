<?php
include '../koneksi.php';

// Logika Pencarian
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT * FROM pelanggan WHERE nama_perusahaan LIKE '%$keyword%' OR nama_instansi LIKE '%$keyword%' ORDER BY id_pelanggan DESC";
} else {
    $query = "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Klien - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputRFQCS.css">
    <style>
        .search-container { position: relative; max-width: 400px; margin: 0 auto; }
        .search-input { border-radius: 50px; background-color: #B2B9FF; border: none; padding: 10px 20px; color: white; padding-right: 45px; }
        .search-icon-btn { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: white; }
        .floating-add-btn { position: fixed; bottom: 110px; right: 30px; background-color: #B2B9FF; width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.2); text-decoration: none; color: white; font-size: 2.5rem; z-index: 99; }
        .pagination-custom { display: flex; justify-content: center; gap: 10px; margin-top: 20px; font-weight: bold; }
        /* Tabel Putih Bersih */
        .custom-table td { background-color: white !important; vertical-align: middle; border: 1px solid #dee2e6; }
        .custom-table th { background-color: #ffc1cc !important; border: 1px solid #dee2e6; } /* Warna pink soft sesuai gambar */
    </style>
</head>
<body>

    <nav class="navbar-custom">
        <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" alt="Logo" class="ms-3 me-2"> 
            <span class="fw-black fs-4 text-dark" style="font-weight: 800;">Customer Service</span>
        </div>
        <div class="me-3">
            <a href="logout.php" class="logout-btn">
                <div class="icon-circle"><i class="fa-solid fa-right-from-bracket logout-icon-fa"></i></div>
                <span class="logout-text">Logout</span>
            </a>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <h2 class="text-center fw-black mb-4" style="font-weight: 900;">DATA KLIEN</h2>

        <form method="POST" class="search-container mb-4">
            <input type="text" name="keyword" class="form-control search-input" placeholder="Ketik Nama Proyek/Klien..." value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit" name="cari" class="search-icon-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <div class="table-responsive px-2">
            <table class="custom-table text-center">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 25%;">Nama Klien</th>
                        <th style="width: 25%;">Perusahaan</th>
                        <th style="width: 25%;">Email</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>C-<?= sprintf("%02d", $row['id_pelanggan']) ?></td>
                        <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                        <td><?= $row['tipe_klien'] == 'Perusahaan' ? htmlspecialchars($row['nama_instansi']) : 'Perorangan' ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>
                            <a href="inputdataklien.php?id=<?= $row['id_pelanggan'] ?>" class="text-dark">
                                <i class="fa-solid fa-pen-to-square fs-5"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-custom mb-5">
            <i class="fa-solid fa-angles-left"></i><span>1 2 3 ..</span><i class="fa-solid fa-angles-right"></i>
        </div>
    </div>

    <a href="inputdataklien.php" class="floating-add-btn"><i class="fa-solid fa-plus"></i></a>

    <nav id="navbar" class="bottom-nav">
        <a href="inputrfq.php" class="nav-item"><i class="fa-solid fa-file-circle-check text-white" style="font-size: 24px;"></i></a>
        <a href="kelolarfq.php" class="nav-item"><i class="fa-solid fa-file-lines text-white" style="font-size: 24px;"></i></a>
        <a href="../dashboard/cs.php" class="nav-item"><i class="fa-solid fa-house text-white" style="font-size: 24px;"></i></a>
        <a href="laporannegoisasi.php" class="nav-item"><i class="fa-solid fa-paper-plane text-white" style="font-size: 24px;"></i></a>
        <a href="dataklien.php" class="active-cycle"><i class="fa-solid fa-user-group" style="color: #8B93FF; font-size: 30px;"></i></a>
    </nav>
</body>
</html>