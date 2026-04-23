<?php
include '../koneksi.php';

// 1. Ambil data Statistik secara Dinamis dari tabel boq
$q_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM boq WHERE status_boq = 'Disetujui'");
$total_disetujui = mysqli_fetch_assoc($q_total)['total'];

// 2. Logika Pencarian
$keyword = "";
$base_query = "SELECT n.id_nego, r.deskripsi as nama_proyek, n.status_nego, b.status_boq, b.id_boq, b.total_biaya
               FROM boq b
               JOIN data_rfq r ON b.id_rfq = r.id_rfq
               LEFT JOIN negosiasi_harga n ON b.id_boq = n.id_boq";

if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = $base_query . " WHERE r.deskripsi LIKE '%$keyword%' ORDER BY b.id_boq DESC";
} else {
    $query = $base_query . " ORDER BY b.id_boq DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Negosiasi - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputRFQCS.css">
    <style>
        .custom-table th { background-color: #FFC2D1 !important; border: 1.5px solid #000; font-weight: 900; }
        .custom-table td { background-color: white !important; border: 1.5px solid #000; font-weight: 700; }
        .badge-status { 
            padding: 4px 12px; 
            border-radius: 50px; 
            border: 1.5px solid black; 
            font-size: 10px; 
            text-transform: uppercase;
            font-weight: 900;
        }
    </style>
</head>
<body>

    <header class="navbar-custom">
        <div class="navbar-left"> 
            <img src="../assets/img/logo.png" alt="BuildBase" class="logo-img">
            <span class="navbar-brand-text">Finance</span>
        </div>
        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle"><i class="fa-solid fa-right-from-bracket logout-icon-fa"></i></div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="container mt-4 mb-32 px-4">
        <h2 class="text-center font-black text-2xl uppercase mb-6">Riwayat & Status BoQ</h2>

        <div class="bg-[#B2B9FF] rounded-[30px] p-6 flex items-center justify-center space-x-4 mb-6 border-2 border-black shadow-[4px_4px_0px_#000]">
            <img src="https://cdn-icons-png.flaticon.com/512/3281/3281306.png" class="w-16 h-16" alt="Icon">
            <p class="font-black text-lg"><?= $total_disetujui ?> BoQ Telah Disetujui</p>
        </div>

        <form method="POST" class="flex space-x-2 mb-6">
            <div class="flex-grow flex items-center bg-[#B2B9FF] px-5 py-3 rounded-full border-2 border-black">
                <input type="text" name="keyword" placeholder="Cari Nama Proyek..." value="<?= $keyword ?>" class="bg-transparent w-full outline-none placeholder-white font-bold text-white">
                <button type="submit" name="cari"><i class="fa-solid fa-magnifying-glass text-white text-xl"></i></button>
            </div>
        </form>

        <div class="overflow-hidden rounded-xl border-2 border-black">
            <table class="custom-table w-full text-center text-sm">
                <thead>
                    <tr>
                        <th width="15%">ID BoQ</th>
                        <th width="40%">Nama Proyek</th>
                        <th width="25%">Status Akhir</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>BOQ-<?= str_pad($row['id_boq'], 3, "0", STR_PAD_LEFT) ?></td>
                        <td class="text-left px-4"><?= $row['nama_proyek'] ?></td>
                        <td>
                            <?php 
                                $status = $row['status_boq'];
                                $color = ($status == 'Disetujui') ? 'bg-green-300' : 'bg-yellow-200';
                            ?>
                            <span class="badge-status <?= $color ?> text-black">
                                <?= $status ?>
                            </span>
                        </td>
                        <td>
                            <a href="negoisasi.php?id=<?= $row['id_boq'] ?>" class="text-indigo-600">
                                <i class="fa-solid fa-circle-info text-2xl"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="laporankeuangan.php" class="nav-item"><i class="fa-solid fa-file-invoice-dollar text-white text-2xl"></i></a>
        <a href="../dashboard/finance.php" class="nav-item"><i class="fa-solid fa-house text-white text-2xl"></i></a>
        <a href="riwayatnegoisasi.php" class="active-cycle"><i class="fa-solid fa-handshake text-[#8B93FF] text-3xl"></i></a>
        <a href="evaluasi.php" class="nav-item"><i class="fa-solid fa-shield-halved text-white text-2xl"></i></a>
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