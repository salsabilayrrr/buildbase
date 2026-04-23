<?php
include '../koneksi.php';
$id_boq = $_GET['id'];

// Ambil data untuk ditampilkan di bagian Detail Proyek
$query = mysqli_query($conn, "SELECT b.id_boq, r.deskripsi 
                               FROM boq b 
                               JOIN data_rfq r ON b.id_rfq = r.id_rfq 
                               WHERE b.id_boq = '$id_boq'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Negoisasi Harga - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputNegoFinance.css">
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

    <main class="p-6">
        <h1 class="text-center font-black text-xl uppercase mt-4 tracking-tighter">
            Input Negosiasi Harga
        </h1>

        <div class="main-card mt-8 p-8">
            <form action="simpan_instruksi.php" method="POST">
                <input type="hidden" name="id_boq" value="<?= $id_boq ?>">

                <div class="mb-8">
                    <h2 class="font-black text-sm uppercase mb-2 ml-4">Detail Proyek</h2>
                    <div class="bg-white rounded-[35px] p-6 shadow-sm border border-black/5">
                        <p class="font-bold text-sm text-gray-800 leading-relaxed italic">
                            Analisis Biaya & Margin:<br>
                            Harga besi D13 dari Estimator terlalu tinggi untuk proyek <?= $data['deskripsi'] ?>.
                        </p>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="font-black text-sm uppercase mb-2 ml-4">Kirim Instruksi Baru ke CS</h2>
                    <div class="bg-white rounded-[35px] p-6 shadow-sm border border-black/5">
                        <textarea name="pesan_instruksi" class="w-full h-24 outline-none border-none resize-none font-bold text-sm italic" placeholder="Ketik instruksi negoisasi di sini..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end mt-10">
                    <button type="submit" class="btn-kirim-cs">
                        Kirim Instruksi CS
                    </button>
                </div>
            </form>
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