<?php
session_start();

$conn = mysqli_connect("localhost","root","","buildbase_db");

if(!$conn){
    die("Koneksi gagal: ".mysqli_connect_error());
}

if(isset($_POST['kirim_validasi'])){

    $id_proyek = "PROYEK-001";
    $keputusan = $_POST['keputusan'];
    $catatan = $_POST['catatan'];

    if($keputusan == "tolak" && empty($catatan)){
        echo "<script>alert('Catatan wajib diisi jika menolak!');</script>";
    } else {

        $query = "INSERT INTO validasi_engineer (id_proyek, keputusan, catatan) VALUES
                    ('$id_proyek','$keputusan','$catatan')";

        mysqli_query($conn,$query);

        echo "<script>
        alert('Validasi berhasil disimpan');
        window.location.href='../dashboard/engineer.php';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Validasi - Engineer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleValidasiEngineer.css">
</head>
<body>

    <header class="dashboard-header">
        <div class="header-left">
            <img src="../assets/img/logo.png" class="header-logo" alt="Logo">
            <span class="header-title">Engineer</span>
        </div>
            <a href="../logout.php" class="btn-logout-pill" style="text-decoration: none;">
                <div class="logout-icon-box">
                    <img src="../assets/img/logout.png" alt="Logout">
                </div>
                <span class="logout-text">Logout</span>
            </a>
    </header>

    <main class="scroll-content">
        <h2 class="main-page-title">Validasi</h2>

        <div class="info-card">
            <p>
                📁 <strong>Proyek: Proyek Jembatan A (ID: PROYEK-001)</strong><br>
                File: JembatanA_v1.1.pdf<br>
                Oleh: Drafter (13 Nov 2025, 10:00)<br>
                Riwayat Versi: [v1.1 (Current)] [v1.0]
            </p>
        </div>

        <div class="form-card-container">
            <div class="image-preview-box">
                <img src="../assets/img/jembatan.png" alt="Jembatan" class="img-fluid rounded-4 border-black">
            </div>
            
            <form method="POST">
            <div class="decision-panel">
                <p class="panel-subtitle">PANEL KEPUTUSAN (Sesuai UC-2)</p>
                <p class="label-bold">Keputusan Anda :</p>
                
                <div class="radio-group">
                    <label class="radio-item">
                        <input type="radio" name="keputusan" value="setuju" checked> Setujui
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="keputusan" value="tolak"> Tolak & Minta Revisi
                    </label>
                </div>

                <p class="label-bold" style="margin-top: 15px;">Catatan Validasi (Wajib diisi jika Tolak) :</p>
                <input type="text" name="catatan" class="form-input-pill" placeholder="Ukuran kolom tidak ...">
                
                <button type="submit" name="kirim_validasi" class="btn-send-action">
                    <img src="../assets/img/send.png" width="24">
                    <span>KIRIM HASIL VALIDASI</span>
                </button>
            </div>
            </form>
        </div>
    </main>

    <nav class="bottom-nav" id="mainNavbar">
        <div class="nav-item">
            <div class="active-extra-circle">
                <img src="../assets/img/validasi.png" class="nav-icon-active" alt="Validasi">
            </div>
        </div>
        <div class="nav-item">
            <a href="../dashboard/engineer.php">
                <img src="../assets/img/home.png" class="nav-icon-side" alt="Home">
            </a>
        </div>
        <div class="nav-item">
            <img src="../assets/img/database.png" class="nav-icon-side" alt="Edit">
        </div>
    </nav>

    <script>
        const navbar = document.getElementById('mainNavbar');
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => { navbar.style.transform = 'translateY(120px)'; });
            input.addEventListener('blur', () => { navbar.style.transform = 'translateY(0)'; });
        });
    </script>
</body>
</html>