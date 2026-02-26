<?php
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'qc'){
    header("Location: ../../index.php");
    exit;
}

include "../koneksi.php";

if(isset($_POST['simpan'])){

    $id_produksi = $_POST['id_produksi'];
    $hasil = isset($_POST['hasil']) ? $_POST['hasil'] : '';
    $catatan = $_POST['catatan_temuan'];

    $dimensi = isset($_POST['dimensi_sesuai']) ? 1 : 0;
    $material = isset($_POST['kualitas_material']) ? 1 : 0;
    $finishing = isset($_POST['finishing_rapi']) ? 1 : 0;

    $nama_file = "";

    if(isset($_FILES['bukti_foto']) && $_FILES['bukti_foto']['name'] != ""){
        $nama_file = $_FILES['bukti_foto']['name'];
        $tmp = $_FILES['bukti_foto']['tmp_name'];

        move_uploaded_file($tmp, "../uploads/".$nama_file);
    }

    $query = "INSERT INTO pemeriksaan_qc (id_produksi, hasil, dimensi_sesuai, kualitas_material, finishing_rapi, catatan_temuan, bukti_foto)
                VALUES ('$id_produksi','$hasil','$dimensi','$material','$finishing','$catatan','$nama_file')";

    if(mysqli_query($conn,$query)){
        echo "<script>alert('Laporan berhasil disimpan!');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Laporan QC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/styleDokumenQc.css">
</head>
<body>

        <div class="dashboard-header">
            <div class="header-left">
                <img src="../assets/img/logo.png" class="header-logo">
                <span class="header-title">Quality Control</span>
            </div>
            <a href="../logout.php" class="btn-logout-pill">
                <div class="logout-icon-box">
                    <img src="../assets/img/logout.png" alt="icon">
                </div>
                <span class="logout-text">Logout</span>
            </a>
        </div>

<main class="main-wrapper container py-4">
    <div class="text-center mb-3">
        <img src="../assets/img/doc.png" class="doc-header-icon" style="width: 80px;">
    </div>

    <h4 class="text-center title-text mb-4">
        Input Laporan Inspeksi<br>Produksi
    </h4>

    <div class="form-card-qc p-4">
    <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">ID Produksi :</label>
                <input type="text" name="id_produksi" class="form-control custom-input" placeholder="PROD-2025-X" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Hasil Pemeriksaan :</label>
                <div class="ms-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="hasil" id="lolos" value="Lolos" required>
                        <label class="form-check-label" for="lolos">Lolos</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="hasil" id="revisi" value="Revisi">
                        <label class="form-check-label" for="revisi">Gagal / Revisi</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Parameter Cek :</label>
                <div class="ms-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dimensi_sesuai" value="1" id="c1">
                        <label class="form-check-label" for="c1">Dimensi Sesuai</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="kualitas_material" value="1" id="c2">
                        <label class="form-check-label" for="c2">Kualitas Material</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="finishing_rapi" value="1" id="c3">
                        <label class="form-check-label" for="c3">Finishing Rapi</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan Temuan :</label>
                <input type="text" name="catatan_temuan" class="form-control custom-input" placeholder="Tulis Detail Catatan">
            </div>

            <div class="mb-3">
                <label class="form-label">Bukti Foto :</label>
                <input type="file" name="bukti_foto" class="form-control custom-input">
            </div>

            <div class="text-center mt-4">
                <button type="submit" name="simpan" class="btn-save-qc">
                    Simpan Laporan
                </button>
            </div>

        </form>
    </div>
</main>

<div class="bottom-nav-full" id="navbar">
    <div class="nav-item">
        <a href="../dashboard/qc.php">
            <img src="../assets/img/home.png" class="icon-nav-home">
        </a>
    </div>
    <div class="nav-item">
        <div class="nav-folder-circle">
            <img src="../assets/img/folder.png" class="icon-nav-folder">
        </div>
    </div>
</div>

<script>
    // Pilih elemen navbar berdasarkan ID
    const navbar = document.getElementById('navbar');
    // Pilih semua input dan textarea
    const inputs = document.querySelectorAll('input, textarea');

    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            // Sembunyikan navbar ke bawah sejauh 100px
            navbar.style.transform = 'translateY(100px)';
        });
        input.addEventListener('blur', () => {
            // Tampilkan kembali navbar ke posisi semula
            navbar.style.transform = 'translateY(0)';
        });
    });
</script>

</body>
</html>