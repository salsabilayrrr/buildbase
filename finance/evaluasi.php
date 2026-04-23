<?php
session_start();
include '../koneksi.php';

$id_boq = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if (empty($id_boq)) {
    header("Location: ../dashboard/finance.php"); 
    exit;
}

// Ambil Data Header
$query_header = "SELECT b.id_boq, r.deskripsi as nama_proyek, p.nama_perusahaan, b.status_boq 
                 FROM boq b 
                 JOIN data_rfq r ON b.id_rfq = r.id_rfq 
                 JOIN pelanggan p ON r.id_pelanggan = p.id_pelanggan
                 WHERE b.id_boq = '$id_boq'";
$res_header = mysqli_query($conn, $query_header);
$header = mysqli_fetch_assoc($res_header);

// Ambil Rincian Material
// 2. Ambil Rincian Estimasi Biaya (Material)
// Kita JOIN ke tabel material agar bisa ambil kolom 'nama_material'
$query_detail = "SELECT db.*, m.nama_material 
                 FROM detail_boq db
                 LEFT JOIN material m ON db.id_material = m.id_material 
                 WHERE db.id_boq = '$id_boq'";
$result_detail = mysqli_query($conn, $query_detail);
$result_detail = mysqli_query($conn, $query_detail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildBase - Evaluasi & Persetujuan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleEvaluasiFinance.css">
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

    <main class="p-4">
        <h1 class="text-center font-black text-2xl uppercase tracking-tighter mt-4">
            Evaluasi & Persetujuan<br>Bill of Quantity
        </h1>

        <div class="main-card mt-6">
            
            <div class="bg-white rounded-[30px] p-5 shadow-sm border border-black/5">
                <p class="font-bold text-sm">Proyek: <?= $header['nama_proyek'] ?> (<?= $header['nama_perusahaan'] ?>)</p>
                <p class="font-bold text-sm">ID BoQ: BOQ-<?= str_pad($header['id_boq'], 3, "0", STR_PAD_LEFT) ?> (Dari: Estimator)</p>
                <p class="font-bold text-sm">Status: [ <?= $header['status_boq'] ?> ]</p>
            </div>

            <h2 class="font-black text-black text-sm mt-6 uppercase italic">Rincian Estimasi Biaya</h2>

            <div class="overflow-hidden rounded-xl border border-black mt-2">
                <table class="w-full text-center text-xs font-bold border-collapse">
                    <thead>
                        <tr class="bg-[#FFC2D1]">
                            <th class="border-b border-r border-black p-2">Material</th>
                            <th class="border-b border-r border-black p-2">Qty</th>
                            <th class="border-b border-r border-black p-2">Harga Satuan</th>
                            <th class="border-b border-black p-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_total = 0;
                        while($row = mysqli_fetch_assoc($result_detail)): 
                            // Ubah 'qty' menjadi 'jumlah' sesuai database kamu
                            $total_per_item = $row['jumlah'] * $row['harga_satuan'];
                            $grand_total += $total_per_item;
                        ?>
                        <tr>
                            <td class="text-left"><?= $row['nama_material'] ?? 'Material Baru/Custom' ?></td>
                            <td><?= $row['jumlah'] ?></td> <td><?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
                            <td><?= number_format($total_per_item, 0, ',', '.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-[35px] p-5 mt-6 shadow-sm border border-black/5">
                <p class="font-black text-xs uppercase">Panel Keputusan</p>
                <p class="text-[10px] font-bold text-gray-700 mt-1">Catatan Evaluasi (Internal):</p>
                <textarea class="w-full h-12 mt-1 text-sm font-bold outline-none border-none resize-none" placeholder="Harga besi terlalu tinggi, potensi nego..."></textarea>
            </div>

            <div class="mt-6 space-y-3">
                <form action="proses_evaluasi.php" method="POST">
                    <input type="hidden" name="id_boq" value="<?= $id_boq ?>">
                    
                    <a href="negoisasi.php?id=<?= $id_boq ?>" class="btn-evaluasi text-center mb-3">AJUKAN NEGOSIASI</a>
                    
                    <button type="submit" name="aksi" value="setuju" class="btn-evaluasi w-full mb-3">REKOMENDASI SETUJU</button>
                    
                    <button type="button" onclick="konfirmasiKembali()" class="btn-evaluasi w-full">KEMBALIKAN KE ESTIMATOR</button>
                </form>

                <script>
                function konfirmasiKembali() {
                    if(confirm("Apakah Anda yakin ingin mengembalikan BoQ ini ke Estimator untuk direvisi?")) {
                        alert("Permintaan revisi telah dikirim ke Estimator.");
                        window.location.href = "../dashboard/finance.php";
                    }
                }
                </script>
            </div>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="../finance/laporankeuangan.php" class="nav-item">
            <i class="fa-solid fa-file-invoice-dollar text-white" style="font-size: 24px;"></i>
        </a>
        <a href="finance.php" class="nav-item">
            <i class="fa-solid fa-house text-white" style="font-size: 24px;"></i>
        </a>
        <a href="../finance/riwayatnegoisasi.php" class="nav-item">
            <i class="fa-solid fa-handshake text-white" style="font-size: 24px;"></i>
        </a>
        <a href="../finance/evaluasi.php" class="active-cycle">
            <i class="fa-solid fa-shield-halved text-white" style="color: #8B93FF; font-size: 30px;"></i>
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