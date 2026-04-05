<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// --- AMBIL DATA DARI SESSION ---
$session_perusahaan = $_SESSION['reject_data']['perusahaan'] ?? '';
$session_proyek     = $_SESSION['reject_data']['proyek'] ?? '';
// -------------------------------

if (isset($_POST['submit'])) {
    $nama_perusahaan = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $nama_proyek     = mysqli_real_escape_string($conn, $_POST['nama_proyek']);
    $tgl_penolakan   = mysqli_real_escape_string($conn, $_POST['tgl_penolakan']);
    $nama_petugas    = mysqli_real_escape_string($conn, $_POST['nama_petugas']);
    $alasan          = mysqli_real_escape_string($conn, $_POST['alasan']);

    $query = "INSERT INTO alasan_penolakan (perusahaan, proyek, tanggal, petugas, alasan) 
                VALUES ('$nama_perusahaan', '$nama_proyek', '$tgl_penolakan', '$nama_petugas', '$alasan')";

    if (mysqli_query($conn, $query)) {
        // Hapus session data reject setelah berhasil simpan agar bersih
        unset($_SESSION['reject_data']);
        
        echo "<script>
                alert('Data Penolakan Berhasil Disimpan!');
                window.location.href='penolakan.php';
                </script>";
        exit;
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
    <title>Alasan Penolakan - Manajemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/stylePenolakanManager.css">
</head>
<body>

    <header class="dashboard-header">
        <div class="header-left">
            <img src="../assets/img/logo.png" class="header-logo" alt="Logo">
            <span class="header-title">Manajemen</span>
        </div>
        <a href="../logout.php" class="btn-logout-pill">
            <div class="logout-icon-box">
                <img src="../assets/img/logout.png" alt="Logout">
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="scroll-content">
        <div class="header-title-container">
            <h2 class="main-page-title" style="margin-top: 20px;">Alasan Penolakan</h2>
        </div>

        <div class="form-card-container">
    <form action="" method="POST">
        <div class="form-body">
            <label style="font-size: 12px; color: #666; margin-left: 15px;">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" 
                   value="<?php echo $session_perusahaan; ?>" 
                   class="form-input-pill" readonly required>

            <label style="font-size: 12px; color: #666; margin-left: 15px; margin-top: 10px;">Nama Proyek</label>
            <input type="text" name="nama_proyek" 
                   value="<?php echo $session_proyek; ?>" 
                   class="form-input-pill" readonly required>
            
            <hr>

            <input type="text" name="tgl_penolakan" placeholder="Tanggal Penolakan *" class="form-input-pill" onfocus="(this.type='date')" required>
            <input type="text" name="nama_petugas" placeholder="Nama Petugas *" class="form-input-pill" required>
            
            <textarea name="alasan" placeholder="Alasan Penolakan *" class="form-input-pill" style="height: 150px; border-radius: 20px; resize: none;" required></textarea>
            
            <button type="submit" name="submit" class="btn-submit-pill">Submit</button>
        </div>
    </form>
</div>
    </main>

    <nav class="bottom-nav" id="navbar">
        <div class="nav-item">
            <a href="persetujuanProduksi.php"><img src="../assets/img/berkas.png" class="nav-icon-side"></a>
        </div>
        <div class="nav-item">
            <div class="active-extra-circle"> <a href="penolakan.php">
                    <img src="../assets/img/arsip.jpg" class="nav-icon-active">
                </a>
            </div>
        </div>
        <div class="nav-item">
            <a href="../dashboard/manager.php"><img src="../assets/img/home.png" class="nav-icon-side"></a>
        </div>
        <div class="nav-item">
            <a href="kelolaPengguna.php"><img src="../assets/img/akun.jpg" class="nav-icon-side"></a>
        </div>
    </nav>

    <script>
        const navbar = document.getElementById('navbar');
        const inputs = document.querySelectorAll('input, textarea');

        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                navbar.style.transform = 'translateY(150px)';
            });
            input.addEventListener('blur', () => {
                navbar.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>