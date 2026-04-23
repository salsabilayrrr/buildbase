<?php
include '../koneksi.php';

$id_boq = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Ambil info proyek dan pesan terakhir dari Finance
$query = mysqli_query($conn, "SELECT b.id_boq, r.deskripsi, 
                               (SELECT isi_pesan FROM pesan_negosiasi WHERE id_boq = b.id_boq AND pengirim = 'finance' ORDER BY waktu_kirim DESC LIMIT 1) as pesan_finance
                               FROM boq b 
                               JOIN data_rfq r ON b.id_rfq = r.id_rfq 
                               WHERE b.id_boq = '$id_boq'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data Proyek Tidak Ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Negoisasi Harga - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleNegoisasiFinance.css">
</head>
<body class="bg-[#f8faff] pb-32">
    <header class="navbar-custom">
        <div class="flex items-center">
            <img src="../assets/img/logo.png" alt="Logo" class="w-12 h-12 ml-4">
            <span class="text-xl font-black ml-2">Customer Service</span>
        </div>
        <a href="../logout.php" class="logout-btn mr-4">
            <div class="icon-circle"><i class="fa-solid fa-right-from-bracket text-white"></i></div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="p-6">
        <h1 class="text-center font-black text-xl uppercase mt-4 tracking-tighter">Input Negosiasi Harga</h1>

        <div class="main-card mt-8 p-8" style="background-color: #B2B9FF; border-radius: 45px; border: 2.5px solid black; box-shadow: 6px 6px 0px #000;">
            <form action="simpan_nego_cs.php" method="POST">
                <input type="hidden" name="id_boq" value="<?= $id_boq ?>">

                <div class="mb-8 text-left">
                    <h2 class="font-black text-sm uppercase mb-2 ml-4">Detail Proyek</h2>
                    <div class="bg-white rounded-[35px] p-6 border-2 border-black shadow-sm">
                        <p class="font-bold text-sm text-gray-800 leading-relaxed italic">
                            Proyek: <?= $data['deskripsi'] ?><br>
                            Pesan Finance: "<?= $data['pesan_finance'] ?? 'Belum ada instruksi' ?>."
                        </p>
                    </div>
                </div>

                <div class="mb-8 text-left">
                    <h2 class="font-black text-sm uppercase mb-2 ml-4">Kirim Instruksi Baru ke CS</h2>
                    <div class="bg-white rounded-[35px] p-6 border-2 border-black shadow-inner">
                        <textarea name="pesan_klien" class="w-full h-28 outline-none border-none resize-none font-bold text-sm italic" placeholder="Tulis hasil negosiasi klien di sini..." required></textarea>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" name="submit" class="btn-final-price" style="background-color: #5c7cfa; color: white; padding: 10px 25px; border-radius: 50px; font-weight: 900; border: 2px solid black; box-shadow: 3px 3px 0px #000;">
                        Kirim Hasil Nego ke Finance
                    </button>
                </div>
            </form>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="inputrfq.php" class="nav-item"><i class="fa-solid fa-file-circle-check text-white text-2xl"></i></a>
        <a href="kelolarfq.php" class="nav-item"><i class="fa-solid fa-file-lines text-white text-2xl"></i></a>
        <a href="../dashboard/cs.php" class="nav-item"><i class="fa-solid fa-house text-white text-2xl"></i></a>
        <a href="laporannegoisasi.php" class="active-cycle"><i class="fa-solid fa-handshake text-[#8B93FF] text-3xl"></i></a>
        <a href="dataklien.php" class="nav-item"><i class="fa-solid fa-user-group text-white text-2xl"></i></a>
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