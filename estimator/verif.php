<?php
include "../koneksi.php";
session_start();

// Proteksi Halaman
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'estimator'){
    header("Location: ../index.php");
    exit;
}

if(isset($_GET['verif'])){
    $id = mysqli_real_escape_string($conn, $_GET['verif']);
    mysqli_query($conn, "UPDATE shop_drawing SET status_verifikasi='Disetujui' WHERE id_drawing='$id'");
    header("Location: verif.php");
    exit;
}

$query = "
SELECT sd.*, rfq.deskripsi, p.nama_perusahaan
FROM shop_drawing sd
LEFT JOIN data_rfq rfq ON sd.id_rfq = rfq.id_rfq
LEFT JOIN pelanggan p ON rfq.id_pelanggan = p.id_pelanggan
ORDER BY sd.id_drawing DESC
";
$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Shop Drawing - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleVerifEstimator.css">
</head>
<body>

    <header class="navbar-custom">
        <div class="flex items-center"> 
            <img src="../assets/img/logo.png" alt="BuildBase" class="w-16 h-16">
            <span class="text-2xl font-black text-black tracking-tighter -ml-2">Estimator</span>
        </div>

        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle">
                <i class="fa-solid fa-right-from-bracket text-black"></i>
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="wrapper">
        <div class="page-title">Verifikasi Shop Drawing</div>

        <?php while($row = mysqli_fetch_assoc($data)) { ?>
            <div class="sd-card">
                <div class="sd-header">
                    <i class="fa-solid fa-file-signature"></i>
                    ID DRAW-<?= str_pad($row['id_drawing'], 3, '0', STR_PAD_LEFT); ?>
                </div>

                <div class="sd-line"></div>

                <p>
                    <b>STATUS :</b> 
                    <?php 
                    if($row['status_verifikasi'] == "Pending"){
                        echo "<span class='status-pending'>MENUNGGU VERIFIKASI</span>";
                    } elseif($row['status_verifikasi'] == "Disetujui"){
                        echo "<span class='status-approve'>SELESAI VERIFIKASI</span>";
                    } else {
                        echo "<span class='status-revisi'>REVISI</span>";
                    }
                    ?>
                </p>

                <p>
                    <b>PROYEK :</b><br>
                    <?= htmlspecialchars($row['deskripsi']); ?> (<?= htmlspecialchars($row['nama_perusahaan']); ?>)
                </p>

                <div class="sd-line"></div>

                <a href="../<?= $row['file_path']; ?>" target="_blank" class="sd-btn">
                    <i class="fa-solid fa-file-pdf me-2"></i> LIHAT DOKUMEN
                </a>

                <?php if($row['status_verifikasi'] == "Pending"){ ?>
                    <a href="?verif=<?= $row['id_drawing']; ?>" class="sd-verif" onclick="return confirm('Setujui dokumen ini?')">
                        <i class="fa-solid fa-check-double me-2"></i> VERIFIKASI SEKARANG
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </main>

    <nav class="bottom-nav">
        <a href="verif.php" class="active-button">
            <i class="fa-solid fa-file-circle-check"></i>
        </a>

        <a href="../dashboard/estimator.php" class="nav-item">
            <i class="fa-solid fa-house"></i>
        </a>

        <a href="daftarrfq.php" class="nav-item">
            <i class="fa-solid fa-clipboard-check"></i>
        </a>

        <a href="buatboq.php" class="nav-item">
            <i class="fa-solid fa-calculator"></i>
        </a>
    </nav>

</body>
</html>