<?php
include "../koneksi.php";

$current_page = basename($_SERVER['PHP_SELF']);

if(isset($_GET['verif'])){
    $id = $_GET['verif'];

    mysqli_query($conn, "UPDATE shop_drawing 
                         SET status_verifikasi='Disetujui'
                         WHERE id_drawing='$id'");

    header("Location: verif.php");
    exit;
}

$query = "
SELECT sd.*, rfq.deskripsi, p.nama_perusahaan
FROM shop_drawing sd
LEFT JOIN data_rfq rfq ON sd.id_rfq = rfq.id_rfq
LEFT JOIN pelanggan p ON rfq.id_pelanggan = p.id_pelanggan
ORDER BY sd.id_drawing DESC
";

$data = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Shop Drawing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@400;600;700&display=swap');

*{box-sizing:border-box}

body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:#dcdcdc;
    min-height:100vh;
    position:relative;
}

/* Navbar */
.navbar-custom {
    background-color: #8B93FF;
    padding: 10px 10px;
    border-radius: 0;
    position: relative;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 50;
}

.logo-section {
    display: flex;
    align-items: center;
}

.logo-img {
    width: 60px;
    height: auto;
}

.logo-text {
    font-size: 32px;
    font-weight: 900;
    color: #000;
    letter-spacing: -1.5px;
    margin-left: -5px;
}
/* Container Utama (Kapsul Putih) */
.logout-btn {
    display: flex;
    align-items: center;
    text-decoration: none;
    background-color: white;
    padding: 4px 20px 4px 4px;
    /* Padding minimal di kiri agar lingkaran biru mepet */
    border-radius: 50px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

/* Lingkaran Biru di belakang Ikon */
.icon-circle {
    background-color: #5c7cfa;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 10px;
}

/* Warna Ikon FontAwesome di dalam lingkaran */
.logout-icon-fa {
    color: black;
    font-size: 18px;
}

/* Teks Logout */
.logout-text {
    color: black;
    font-weight: 800;
    /* Tebal sesuai font Plus Jakarta Sans */
    font-size: 16px;
}

/* CONTENT */
.wrapper{
    width: 100%;
    padding: 60px 20px 200px;
}

.page-title{
    text-align:center;
    font-size:28px;
    font-weight:700;
    margin-bottom:30px;
}

.sd-card p{
    font-size:22px;
}

/* CARD */
.sd-card{
    background:linear-gradient(135deg,#9ea2d8,#b4a1d9);
    padding:30px;
    border-radius:25px;
    margin:30px 0;
    box-shadow:0 15px 30px rgba(0,0,0,0.2);
    width:100%;
}

.sd-header{
    display:flex;
    align-items:center;
    gap:15px;
    font-size:22px;
    font-weight:700;
}

.sd-line{
    border-bottom:2px solid black;
    margin:20px 0;
}

.sd-card p{
    font-size:20px;
}

.sd-btn{
    margin-top:25px;
    display:inline-block;
    padding:18px 40px;
    border-radius:50px;
    border:2px solid black;
    text-decoration:none;
    color:black;
    font-size:20px;
    background:white;
}

.sd-verif{
    margin-top:20px;
    display:block;
    text-align:center;
    font-weight:700;
    cursor:pointer;
    text-decoration:none;
    color:black;
}

/* Bottom Navigation */
.bottom-nav{
    position:fixed;
    bottom:0;
    left:0;
    width:100%;
    height:70px;
    display:flex;
    justify-content:space-around;
    align-items:center;
    background:linear-gradient(to top, #8389f7, #a2a7fb);
    z-index:999;
}

.nav-item {
    font-size: 24px;
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    transition: all 0.3s ease;
}

.active-home {
    background: rgb(95, 22, 147);
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4a54f1 !important;
    border: 5px solid #8389f7;
    margin-top: -50px; /* Efek menonjol */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    /* Pastikan z-index tinggi agar lingkaran tidak terpotong */
    z-index: 10000; 
}

.status-pending { color: orange; font-weight: bold; }
.status-approve { color: green; font-weight: bold; }
.status-revisi  { color: red; font-weight: bold; }

</style>
</head>

<body>

<header class="navbar-custom">
        <div class="logo-section">
            <img src="../assets/img/logo.png" alt="Logo" class="logo-img">
            <span class="logo-text">Estimator</span>
        </div>
        <a href="../index.php" class="logout-btn">
            <div class="icon-circle">
                <i class="fas fa-sign-out-alt logout-icon-fa"></i>
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

<div class="wrapper">

    <div class="page-title">Verifikasi Shop Drawing</div>

<?php while($row=mysqli_fetch_assoc($data)) { ?>

    <div class="sd-card">

        <div class="sd-header">
            <i class="fa-solid fa-file"></i>
            ID SD-<?= str_pad($row['id_drawing'],3,'0',STR_PAD_LEFT); ?>
        </div>

        <div class="sd-line"></div>

       <p>
        <b>Status :</b>
        <?php 
        if($row['status_verifikasi']=="Pending"){
            echo "<span class='status-pending'>Menunggu Verifikasi</span>";
        }elseif($row['status_verifikasi']=="Disetujui"){
            echo "<span class='status-approve'>Selesai Verifikasi</span>";
        }else{
            echo "<span class='status-revisi'>Revisi</span>";
        }
        ?>
        </p>

        <div class="sd-line"></div>

        <p>
        <b>Proyek :</b>
        <?= $row['deskripsi']; ?> (<?= $row['nama_perusahaan']; ?>)
        </p>

        <div class="sd-line"></div>

        <!-- LIHAT PDF -->
        <a href="../<?= $row['file_path']; ?>" target="_blank" class="sd-btn">
            Lihat Dokumen Shop Drawing
        </a>

        <!-- TOMBOL VERIFIKASI -->
        <?php if($row['status_verifikasi']=="Pending"){ ?>
            <a href="?verif=<?= $row['id_drawing']; ?>" class="sd-verif">
                Verifikasi
            </a>
        <?php } ?>

    </div>

<?php } ?>

</div>

  <nav class="bottom-nav">
    
    <a href="../estimator/verif.php" class="nav-item <?= ($current_page == 'verif.php') ? 'active-side' : '' ?>">
        <img src="../assets/img/est1.png" class="nav-icon">
    </a>

    <a href="estimator.php" class="nav-item <?= ($current_page == 'estimator.php') ? 'active-side' : '' ?>">
        <img src="../assets/img/home.png" class="nav-icon">
    </a>

    <a href="../estimator/daftarrfq.php" class="nav-item <?= ($current_page == '../estimator/daftarrfq.php') ? 'active-side' : '' ?>">
        <img src="../assets/img/est2.png" class="nav-icon">
    </a>

    <a href="../estimator/buatboq.php" class="nav-item <?= ($current_page == '../estimator/buatboq.php') ? 'active-home' : '' ?>">
        <img src="../assets/img/est3.png" class="nav-icon">
    </a>
</body>
</html>