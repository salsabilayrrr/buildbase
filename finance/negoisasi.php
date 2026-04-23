<?php
include '../koneksi.php';
$id_boq = $_GET['id'];

// Ambil info proyek
$query = mysqli_query($conn, "SELECT b.*, r.deskripsi, p.nama_perusahaan 
                               FROM boq b 
                               JOIN data_rfq r ON b.id_rfq = r.id_rfq 
                               JOIN pelanggan p ON r.id_pelanggan = p.id_pelanggan 
                               WHERE b.id_boq = '$id_boq'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Negoisasi Proyek - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleNegoisasiFinance.css">
</head>
<body>
    <header class="navbar-custom">
        <div class="navbar-left">
            <img src="../assets/img/logo.png" alt="Logo" class="logo-img">
            <span class="navbar-brand-text">Finance</span>
        </div>
        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle"><i class="fa-solid fa-right-from-bracket logout-icon-fa text-white"></i></div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="p-4 pb-40"> 
        <h1 class="text-center font-black text-xl uppercase mt-4 tracking-tighter">
            Negoisasi Proyek<br><?= strtoupper($data['deskripsi']) ?>
        </h1>

        <div class="main-card mt-6 p-6">
            <div class="flex justify-end mb-4">
                <a href="inputnegoisasi.php?id=<?= $id_boq ?>" class="btn-input-nego">
                    <i class="fa-solid fa-square-plus text-3xl mr-2 text-[#8B93FF]"></i>
                    <span class="font-black text-xs text-left leading-tight uppercase">Input<br>Negosiasi</span>
                </a>
            </div>

            <div class="mb-4 font-bold text-sm space-y-1">
                <p>Proyek: <?= $data['deskripsi'] ?> (<?= $data['nama_perusahaan'] ?>)</p>
                <p>ID BoQ: BOQ-<?= str_pad($data['id_boq'], 3, "0", STR_PAD_LEFT) ?></p>
                <p>Harga Awal Ditawarkan: <span class="text-indigo-900">Rp <?= number_format($data['total_biaya'] ?? 0, 0, ',', '.') ?></span></p>
            </div>

            <h2 class="font-black text-xs uppercase mb-2 italic tracking-tighter text-gray-700">Riwayat Negosiasi</h2>
            
            <div class="border-2 border-black rounded-xl overflow-hidden mb-6 shadow-sm">
                <table class="w-full text-[11px] font-bold border-collapse">
                    <tr class="border-b-2 border-black">
                        <td class="p-3 border-r-2 border-black bg-white w-1/3 text-center">[14 Nov '25] Customer :</td>
                        <td class="p-3 bg-white italic text-center text-gray-500">"Budget kami hanya 75jt."</td>
                    </tr>
                    <tr>
                        <td class="p-3 border-r-2 border-black bg-white text-center">[13 Nov '25] Finance :</td>
                        <td class="p-3 bg-white italic text-center text-gray-500">"Penawaran baru kami Rp 77jt."</td>
                    </tr>
                </table>
            </div>

            <h2 class="font-black text-xs uppercase mb-2 tracking-tighter text-gray-700">Kirim Penawaran/Tanggapan Baru</h2>
            <div class="bg-white rounded-[30px] p-5 border-2 border-black shadow-inner mb-6">
                <p class="font-black text-[10px] uppercase text-indigo-900 mb-1">Analisis Biaya & Margin:</p>
                <textarea class="w-full h-16 outline-none border-none resize-none font-bold text-sm italic" placeholder="Ketik pesan analisis di sini..."></textarea>
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="konfirmasiHargaFinal(<?= $id_boq ?>)" class="btn-final-price">
                    Setujui Harga Final
                </button>
            </div>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="laporankeuangan.php" class="nav-item"><i class="fa-solid fa-file-invoice-dollar text-white text-2xl"></i></a>
        <a href="../dashboard/finance.php" class="nav-item"><i class="fa-solid fa-house text-white text-2xl"></i></a>
        <a href="riwayatnegoisasi.php" class="active-cycle"><i class="fa-solid fa-handshake text-[#8B93FF] text-3xl"></i></a>
        <a href="evaluasi.php" class="nav-item"><i class="fa-solid fa-shield-halved text-white text-2xl"></i></a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function konfirmasiHargaFinal(idBoq) {
            Swal.fire({
                title: 'Konfirmasi Harga Final',
                text: "Setujui harga ini dan tandai sebagai 'Disetujui'?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5c7cfa',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'proses_setuju_final.php?id=' + idBoq;
                }
            })
        }

        const navbarElement = document.getElementById('navbar');
        const allInputs = document.querySelectorAll('textarea, input');

        allInputs.forEach(el => {
            el.addEventListener('focus', () => { 
                navbarElement.style.transform = 'translateY(100px)'; 
            });
            el.addEventListener('blur', () => { 
                navbarElement.style.transform = 'translateY(0)'; 
            });
        });
    </script>
</body>
</html>