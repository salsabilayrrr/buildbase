<?php
session_start();
$conn = mysqli_connect("localhost","root","","buildbase_db");

// 1. TANGKAP ID DARI URL (dikirim dari halaman database)
$id_drawing = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// 2. AMBIL DATA DARI DATABASE SECARA OTOMATIS
$nama_proyek = "Proyek tidak ditemukan";
$file_path = "";
if (!empty($id_drawing)) {
    // Join dengan data_rfq untuk mendapatkan deskripsi proyek
    $q_detail = mysqli_query($conn, "SELECT s.*, r.deskripsi FROM shop_drawing s 
                                     JOIN data_rfq r ON s.id_rfq = r.id_rfq 
                                     WHERE s.id_drawing = '$id_drawing'");
    $data = mysqli_fetch_assoc($q_detail);
    if ($data) {
        $nama_proyek = $data['deskripsi'];
        $file_path = $data['file_path']; // SESUAI NAMA KOLOM DI TABEL KAMU
    }
}

// 3. PROSES SIMPAN VALIDASI
if(isset($_POST['kirim_validasi'])){
    $keputusan = $_POST['keputusan']; // 'Disetujui' atau 'Revisi'
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

    if($keputusan == "Revisi" && empty($catatan)){
        echo "<script>alert('Catatan wajib diisi jika menolak/revisi!');</script>";
    } else {
        // UPDATE status pada baris yang sudah ada (bukan INSERT baru)
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleValidasiEngineer.css">
    <style>
        .pdf-preview-container {
            width: 100%;
            height: 450px;
            background: #fff;
            border-radius: 15px;
            border: 2px solid #000;
            margin-bottom: 20px;
            overflow: hidden;
        }
        iframe { width: 100%; height: 100%; border: none; }
    </style>
</head>
<body>

    <header class="dashboard-header">
        <div class="header-left">
            <img src="../assets/img/logo.png" class="header-logo" alt="Logo">
            <span class="header-title">Engineer</span>
        </div>
    </header>

    <main class="scroll-content container mt-4">
        <h2 class="main-page-title text-center fw-bold mb-4">VALIDASI</h2>

        <div class="info-card mb-3" style="background:#B2B9FF; border-radius:20px; padding:15px; border: 1px solid #000;">
            <p class="m-0 fw-bold">
                📁 Proyek: <?= htmlspecialchars($nama_proyek) ?> (ID: DRAW-<?= htmlspecialchars($id_drawing) ?>)<br>
                📄 File: <?= basename($file_path) ?>
            </p>
        </div>

        <div class="form-card-container p-4" style="background-color: #C2C7FF; border-radius:30px; border: 1px solid #000;">
            <div class="pdf-preview-container">
                <?php if(!empty($file_path)): ?>
                    <iframe src="../<?= $file_path ?>"></iframe>
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                        Pilih data di halaman database untuk melihat preview
                    </div>
                <?php endif; ?>
            </div>
            
            <form method="POST">
                <div class="decision-panel bg-white p-3 rounded-4 shadow-sm">
                    <p class="fw-bold mb-2">KEPUTUSAN ANDA :</p>
                    <div class="d-flex gap-4 mb-3">
                        <label class="radio-item">
                            <input type="radio" name="keputusan" value="Disetujui" checked> Setujui
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="keputusan" value="Revisi"> Tolak & Revisi
                        </label>
                    </div>

                    <p class="fw-bold mb-2">CATATAN VALIDASI (Wajib jika Revisi) :</p>
                    <textarea name="catatan" class="form-control rounded-4 mb-4" rows="3" placeholder="Contoh: Ukuran kolom tidak sesuai..."></textarea>
                    
                    <button type="submit" name="kirim_validasi" class="btn w-100 text-white fw-bold" style="background:#1e1b4b; border-radius:50px; padding:12px;">
                        KIRIM HASIL VALIDASI
                    </button>
                </div>
            </form>
        </div>
    </main>

    <nav class="bottom-nav">
        <div class="nav-item">
            <div class="active-extra-circle">
                <i class="fa-solid fa-file-circle-check" style="color: #8B93FF; font-size: 30px;"></i>
            </div>
        </div>
        <a href="../dashboard/engineer.php" class="nav-item">
            <i class="fa-solid fa-house text-white" style="font-size: 24px;"></i>
        </a>
        <a href="database.php" class="nav-item">
            <i class="fa-solid fa-file-signature text-white" style="font-size: 24px;"></i>
        </a>
    </nav>

</body>
</html>