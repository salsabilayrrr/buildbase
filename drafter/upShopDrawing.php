<?php
session_start();

include "../koneksi.php";

// Proteksi Halaman
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'drafter'){
    header("Location: ../index.php");
    exit;
}

// LOGIKA OTOMATISASI DATABASE
if (isset($_POST['submit_upload'])) {
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
    $id_user = $_SESSION['user']['id'];

    $target_dir = "../uploads/shop_drawings/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }

    $file_name = time() . "_" . basename($_FILES["file_drawing"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["file_drawing"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO shop_drawing (id_user, nama_file, catatan) VALUES ('$id_user', '$file_name', '$catatan')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Berhasil Diupload!'); 
                    window.location.href='../dashboard/drafter.php'; 
                    </script>";
            exit;
        }
    } else {
        echo "<script>alert('Gagal mengunggah file.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, interactive-widget=resizes-content">
    <title>Upload Gambar - Drafter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleUpShopDrawing.css">
</head>
<body>

    <header class="dashboard-header px-3">
        <div class="header-left">
            <img src="../assets/img/logo.png" class="header-logo">
            <span class="header-title">Drafter</span>
        </div>
        <a href="../logout.php" class="btn-logout-pill">
            <div class="logout-icon-box">
                <img src="../assets/img/logout.png" alt="icon">
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <div class="container-main">
        <a href="../dashboard/drafter.php" class="back-link"> < Kembali ke Daftar Tugas </a>

        <div class="title-pill">Upload Gambar</div>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="upload-card">
                <h6 class="text-start fw-bold mb-3" style="font-size: 13px;">UNGGAH GAMBAR</h6>
                
                <label for="fileInput" class="drop-area">
                    <img src="../assets/img/up.png" width="25" class="mb-2">
                    <p id="fileStatus" style="font-size: 9px; font-weight: bold; color: #444; margin: 0;">
                        SERET FILE (.DWG / .PDF) ATAU BROWSER KE SINI
                    </p>
                    <input type="file" name="file_drawing" id="fileInput" hidden required>
                </label>

                <div class="text-start">
                    <label class="fw-bold" style="font-size: 13px;">Catatan / Penjelasan Gambar :</label>
                    <textarea name="catatan" class="form-input-catatan" placeholder="Perbaikan ukuran kolom..."></textarea>
                </div>

                <button type="submit" name="submit_upload" class="btn-submit">SUBMIT</button>
            </div>
        </form>
    </div>

    <nav class="bottom-nav-full">
        <div class="nav-folder-circle">
            <a href="../drafter/upShopDrawing.php">
                <img src="../assets/img/folder.png" class="icon-nav-folder" alt="Folder Proyek">
            </a>
        </div>
        <div class="nav-item">
            <a href="../dashboard/drafter.php">
                <img src="../assets/img/home.png" class="icon-nav-home">
            </a>
        </div>
        <div class="nav-item">
            <a href="../drafter/revisi.php">
                <img src="../assets/img/load.png" class="icon-nav-load">
            </a>
        </div>
        <div class="nav-item">
            <a href="../drafter/perbaikan.php">
                <img src="../assets/img/revisi.png" class="icon-nav-rev">
            </a>
        </div>
    </nav>

    <script>
        document.getElementById('fileInput').addEventListener('change', function() {
            const statusText = document.getElementById('fileStatus');
            if(this.files.length > 0) {
                statusText.innerHTML = "TERPILIH: " + this.files[0].name;
                statusText.style.color = "#4E5FE1";
            }
        });
    </script>
</body>
</html>