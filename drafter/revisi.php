<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'drafter'){
    header("Location: ../index.php");
    exit;
}

$sql = "SELECT * FROM shop_drawing WHERE status_validasi = 'revisi' ORDER BY id DESC LIMIT 1";
$query_revisi = mysqli_query($conn, $sql);

if (!$query_revisi) {
    die("Query Error: " . mysqli_error($conn)); 
}

$data = mysqli_fetch_assoc($query_revisi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Revisi - Drafter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleRevisiDrafter.css">
</head>
<body>

    <header class="dashboard-header px-3">
        <div class="header-left">
            <img src="../assets/img/logo.png" class="header-logo">
            <span class="header-title">Drafter</span>
        </div>
        <a href="../logout.php" class="btn-logout-pill">
            <div class="logout-icon-box">
                <img src="../assets/img/logout.png" alt="icon">
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <div class="container-main">
        <h2 class="page-title">REVISI</h2>

        <div class="card-gradient">
            <h6 class="card-label">Detail Revisi</h6>
            <div class="inner-white-box">
                <p class="revisi-note">
                    "<?php echo $data['catatan'] ?? 'Ukuran kolom tidak sesuai spek. Harap ganti menjadi besi D16 sesuai BoQ.'; ?>"
                    <span class="date-stamp">- 13/11/25</span>
                </p>
            </div>
        </div>

        <div class="card-gradient mt-4">
            <h6 class="card-label">Riwayat Revisi</h6>
            <div class="table-responsive-custom">
                <table class="table-revisi">
                    <thead>
                        <tr>
                            <th>Versi</th>
                            <th>Tanggal</th>
                            <th>Ket.</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>5.0</td>
                            <td>11/12/2025</td>
                            <td>Kurang Minimalist</td>
                            <td><img src="../assets/img/doc.png" width="20"></td>
                        </tr>
                        <tr>
                            <td>4.0</td>
                            <td>21/11/2025</td>
                            <td>Kurang Luas</td>
                            <td><img src="../assets/img/doc.png" width="20"></td>
                        </tr>
                        <tr>
                            <td>5.0</td>
                            <td>18/11/2025</td>
                            <td>Lahan Tidak Cukup</td>
                            <td><img src="../assets/img/doc.png" width="20"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <nav class="bottom-nav-full">
            <a href="../drafter/upShopDrawing.php">
                <img src="../assets/img/folder.png" class="icon-nav-folder" alt="Folder Proyek">
            </a>
        <div class="nav-item">
            <a href="../dashboard/drafter.php">
                <img src="../assets/img/home.png" class="icon-nav-home">
            </a>
        </div>
        <div class="nav-item">
            <div class="nav-folder-circle">
                <a href="../drafter/revisi.php">
                    <img src="../assets/img/load.png" class="icon-nav-load">
                </a>
            </div>
        </div>
        <div class="nav-item">
            <a href="../drafter/perbaikan.php">
                <img src="../assets/img/revisi.png" class="icon-nav-rev">
            </a>
        </div>
    </nav>

</body>
</html>