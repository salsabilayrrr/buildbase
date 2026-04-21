<?php
session_start();
$conn = mysqli_connect("localhost","root","","buildbase_db");

// 1. TANGKAP ID DARI URL
$id_drawing = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// 2. AMBIL DATA DARI DATABASE
$nama_proyek = "Proyek tidak ditemukan";
$file_path = "";
if (!empty($id_drawing)) {
    $q_detail = mysqli_query($conn, "SELECT s.*, r.deskripsi FROM shop_drawing s 
                                     JOIN data_rfq r ON s.id_rfq = r.id_rfq 
                                     WHERE s.id_drawing = '$id_drawing'");
    $data = mysqli_fetch_assoc($q_detail);
    if ($data) {
        $nama_proyek = $data['deskripsi'];
        $file_path = $data['file_path'];
    }
}

// 3. PROSES SIMPAN VALIDASI
if(isset($_POST['kirim_validasi'])){
    $keputusan = $_POST['keputusan'];
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

    if($keputusan == "Revisi" && empty($catatan)){
        echo "<script>alert('Catatan wajib diisi jika menolak/revisi!');</script>";
    } else {
        $query_update = "UPDATE shop_drawing SET 
                         status_verifikasi = '$keputusan', 
                         catatan_engineer = '$catatan' 
                         WHERE id_drawing = '$id_drawing'";

        if(mysqli_query($conn, $query_update)){
            echo "<script>
                alert('Validasi berhasil disimpan');
                window.location.href='database.php';
            </script>";
        } else {
            echo "<script>alert('Gagal mengupdate database');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi - Engineer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleValidasiEngineer.css">
</head>
<body>

    <header class="navbar-custom">
        <div class="flex items-center"> 
            <img src="../assets/img/logo.png" alt="BuildBase" class="w-16 h-16">
            <span class="text-2xl font-black text-black tracking-tighter -ml-2">Engineer</span>
        </div>

        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle">
                <i class="fa-solid fa-right-from-bracket logout-icon-fa"></i>
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="container mt-4">
        <h2 class="main-page-title text-center mb-4 uppercase tracking-tighter">Validasi</h2>

        <div class="info-card mb-4">
            <p class="m-0 font-bold text-sm">
                📁 Proyek: <?= htmlspecialchars($nama_proyek) ?> (ID: DRAW-<?= htmlspecialchars($id_drawing) ?>)<br>
                📄 File: <?= basename($file_path) ?>
            </p>
        </div>

        <div class="form-card-container mb-5">
            <div class="pdf-preview-container">
                <?php if(!empty($file_path)): ?>
                    <iframe src="../<?= $file_path ?>"></iframe>
                <?php else: ?>
                    <div class="flex items-center justify-center h-full text-gray-500 font-bold">
                        Pilih data di database untuk melihat preview
                    </div>
                <?php endif; ?>
            </div>
            
            <form method="POST">
                <div class="decision-panel bg-white p-4">
                    <p class="font-black mb-3 text-sm">KEPUTUSAN ANDA :</p>
                    <div class="flex gap-6 mb-4">
                        <label class="radio-item">
                            <input type="radio" name="keputusan" value="Disetujui" checked> Setujui
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="keputusan" value="Revisi"> Tolak & Revisi
                        </label>
                    </div>

                    <p class="font-black mb-2 text-sm">CATATAN VALIDASI :</p>
                    <textarea name="catatan" class="form-control rounded-2xl mb-4 border-2 border-black font-bold text-sm" rows="3" placeholder="Contoh: Ukuran kolom tidak sesuai..."></textarea>
                    
                    <button type="submit" name="kirim_validasi" class="btn-send-action">
                        KIRIM HASIL VALIDASI
                    </button>
                </div>
            </form>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="validasi.php" class="home-button">
            <i class="fa-solid fa-file-circle-check text-[#8B93FF] text-3xl"></i>
        </a>

        <a href="../dashboard/engineer.php" class="nav-item">
            <i class="fa-solid fa-house text-white text-2xl"></i>
        </a>

        <a href="database.php" class="nav-item">
            <i class="fa-solid fa-file-signature text-white text-2xl"></i>
        </a>
    </nav>

    <script>
        const navbar = document.getElementById('navbar');
        const inputs = document.querySelectorAll('textarea');

        // Sembunyikan navbar saat mengetik
        inputs.forEach(input => {
            input.addEventListener('focus', () => { navbar.style.transform = 'translateY(100px)'; });
            input.addEventListener('blur', () => { navbar.style.transform = 'translateY(0)'; });
        });
    </script>
</body>
</html>