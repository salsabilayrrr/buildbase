<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

// PERBAIKAN: Cek apakah session user ada sebelum mengakses array-nya
if(!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] != 'drafter'){
    header("Location: ../index.php");
    exit;
}

$query_info = mysqli_query($conn, "SELECT * FROM shop_drawing WHERE status_validasi = 'revisi' ORDER BY id DESC LIMIT 1");
$info = mysqli_fetch_assoc($query_info);

// Variabel untuk trigger notifikasi SweetAlert
$show_success = false;

if (isset($_POST['submit_revisi'])) {
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan_revisi']);
    $id_user = $_SESSION['user']['id'];
    $target_dir = "../uploads/shop_drawings/";
    
    if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_name = time() . "_" . basename($_FILES["file_drawing"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["file_drawing"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO shop_drawing (id_user, nama_file, catatan, status_validasi) 
                VALUES ('$id_user', '$file_name', '$catatan', 'pending')";
        if (mysqli_query($conn, $sql)) {
            $show_success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Unggah Revisi - Drafter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleRevisiDrafter.css">
</head>
<body>

    <header class="dashboard-header">
        <div class="header-left">
            <img src="../assets/img/logo.png" class="header-logo">
            <span class="header-title">Drafter</span>
        </div>
        <a href="../logout.php" class="btn-logout-pill">
            <div class="logout-icon-box"><img src="../assets/img/logout.png"></div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="content-wrapper">
    <div class="container-main">
        <a href="revisi.php" class="back-link"> < Kembali ke Daftar Tugas </a>
        
        <div class="project-info">
            <p>Proyek :<br>
            Proyek jembatan A (ID: PROYEK-001)</p>
        </div>

        <div class="card-gradient">
            <h6 class="card-label">
                <img src="../assets/img/pluss.png" width="14"> 
                PERMINTAAN REVISI (Dari Engineer)
            </h6>
            <div class="inner-white-box">
                <p class="revisi-note">
                    "<?php echo $info['catatan'] ?? 'Ukuran kolom tidak sesuai spek. Harap ganti menjadi besi D16 sesuai BoQ.'; ?>"
                    <span class="date-stamp">- 13/11/25</span>
                </p>
            </div>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="card-gradient">
                <h6 class="card-label">UNGGAH REVISI ANDA (Versi Baru: v1.2)</h6>
                
                <label for="fileInput" class="drop-area">
                    <img src="../assets/img/upload_arrow.png" width="20">
                    <p id="fileStatus" class="drop-text">SERET FILE (.DWG / .PDF) ATAU BROWSER KE SINI</p>
                    <input type="file" name="file_drawing" id="fileInput" hidden required>
                </label>

                <div class="text-start">
                    <label class="input-label" style="font-weight: 900; font-size: 11px;">
                        Catatan untuk Revisi Ini (v1.2): <span class="text-danger" style="font-size: 9px;">*wajib diisi</span>
                    </label>
                    <input type="text" name="catatan_revisi" class="form-input-catatan" placeholder="Perbaikan ukuran ..." required>
                </div>

                <p style="font-size: 9px; font-weight: 900; color: #000; margin-top: 15px; text-align: center;">KIRIM ULANG UNTUK VALIDASI</p>
                <button type="submit" name="submit_revisi" class="btn-submit">SUBMIT</button>
            </div>
        </form>
    </div>
</main>

    <nav class="bottom-nav-full">
        <div class="nav-item">
            <a href="upShopDrawing.php"><img src="../assets/img/folder.png" class="icon-nav-folder"></a>
        </div>
        <div class="nav-item">
            <a href="../dashboard/drafter.php"><img src="../assets/img/home.png" class="icon-nav-home"></a>
        </div>
        <div class="nav-item">
            <a href="revisi.php"><img src="../assets/img/load.png" class="icon-nav-load"></a>
        </div>
        <div class="nav-folder-circle">
            <a href="../drafter/perbaikan.php">
                <img src="../assets/img/revisi.png" class="icon-nav-folder" alt="revisi">
            </a>
        </div>
    </nav>

    <script>
    // Notifikasi sukses setelah submit
    <?php if($show_success): ?>
    Swal.fire({
        title: 'Berhasil!',
        text: 'Revisi telah dikirim untuk validasi.',
        icon: 'success',
        confirmButtonColor: '#4E5FE1',
        confirmButtonText: 'Oke'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'revisi.php';
        }
    });
    <?php endif; ?>

    // Script untuk mengganti teks drop area saat file dipilih
    document.getElementById('fileInput').addEventListener('change', function() {
        const statusText = document.getElementById('fileStatus');
        if(this.files.length > 0) {
            statusText.innerHTML = "FILE: " + this.files[0].name;
            statusText.style.color = "#4E5FE1";
        }
    });
</script>
</body>
</html>