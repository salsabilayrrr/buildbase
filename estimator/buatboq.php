<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if (!$conn) { die("Koneksi gagal: " . mysqli_connect_error()); }

$id_rfq = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query Ambil Data RFQ & File PDF dari Shop Drawing
$query_header = "
    SELECT data_rfq.id_rfq, data_rfq.deskripsi, pelanggan.nama_perusahaan, shop_drawing.file_path 
    FROM data_rfq 
    JOIN pelanggan ON data_rfq.id_pelanggan = pelanggan.id_pelanggan 
    LEFT JOIN shop_drawing ON data_rfq.id_rfq = shop_drawing.id_rfq
    WHERE data_rfq.id_rfq = $id_rfq
";
$result_header = mysqli_query($conn, $query_header);
$data_header = mysqli_fetch_assoc($result_header);

$referensi = $data_header ? "RFQ-" . str_pad($data_header['id_rfq'], 3, "0", STR_PAD_LEFT) : "-";
$proyek = $data_header ? $data_header['deskripsi'] . " (" . $data_header['nama_perusahaan'] . ")" : "Data tidak ditemukan";
$file_pdf = $data_header['file_path'] ?? '#'; // Mengambil path file dari tabel shop_drawing
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembuatan BOQ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <style>
        body { 
        margin: 0; 
        padding: 0; 
        font-family: 'Poppins', sans-serif;
        background-color: #ffffff; 
        padding-bottom: 120px; }

        .navbar-custom { 
        background-color: #8B93FF; 
        padding: 15px 20px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

        .logo-section { 
        display: flex; 
        align-items: center; 
        color: black; }

        .logo-img { 
        width: 50px; }

        .logo-text { 
        font-size: 24px; 
        font-weight: 800; 
        margin-left: 10px; }

        .logout-btn { 
        display: flex; 
        align-items: center; 
        text-decoration: none; 
        background: white; 
        padding: 5px 15px 5px 5px; 
        border-radius: 50px; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.2); }

        .icon-circle { 
        background-color: #1a237e; 
        width: 35px; 
        height: 35px; 
        border-radius: 50%; 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        margin-right: 10px; 
        color: white; }

        .container { 
        padding: 20px; 
        text-align: center; }

        .page-title { 
        font-weight: 800; 
        font-size: 22px; 
        margin: 20px 0; 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        gap: 10px; }

        .btn-back { 
        background-color: #B1BCFD; 
        border: none; 
        padding: 10px 20px; 
        border-radius: 15px; 
        font-weight: 700; 
        cursor: pointer; 
        display: inline-block; 
        margin-bottom: 20px; 
        text-decoration: none; 
        color: black; }

        .info-card { 
        background-color: #C0C5F8; 
        border-radius: 25px; 
        padding: 20px; 
        text-align: left; 
        width: 85%; 
        margin: 0 auto 20px; 
        box-shadow: 0 6px 15px rgba(0,0,0,0.15); }

        .info-line { 
        font-weight: 700; 
        font-size: 15px; 
        margin: 10px 0; 
        border-bottom: 1.5px solid #000; 
        padding-bottom: 5px; }

        .btn-lihat-doc { 
        background-color: #B1BCFD; 
        border: 1.5px solid #000; 
        padding: 10px 30px; 
        border-radius: 20px; 
        font-weight: 700; 
        display: inline-flex; 
        align-items: center; 
        gap: 15px; 
        cursor: pointer; 
        text-decoration: none; 
        color: black; }

        .section-subtitle { 
        font-weight: 700; 
        margin: 30px 0 15px; 
        font-size: 18px; }

        .table-container { 
        width: 100%; 
        overflow-x: auto; }
        
        table { 
        width: 100%; 
        border-collapse: collapse; 
        background-color: #B1BCFD; 
        border: 2px solid black; 
        font-size: 13px; 
        font-weight: 700; }

        th, td { 
        border: 1.5px solid black; 
        padding: 8px; 
        text-align: center; }

        thead { 
        background-color: #8B93FF; }

        .action-btns { 
        display: flex; 
        flex-direction: column; 
        align-items: flex-start; 
        gap: 10px; 
        margin-top: 15px; }

        .btn-tambah { 
        background: white; 
        border: 1.5px solid black; 
        border-radius: 5px; 
        padding: 2px 10px; 
        font-weight: 800; 
        cursor: pointer; }

        .btn-simpan { 
        background: #B1BCFD; 
        border: none; 
        border-radius: 15px; 
        padding: 5px 20px; 
        font-weight: 700; 
        cursor: pointer; }

        .btn-kirim { 
        background: #B1BCFD; 
        border: none; 
        border-radius: 15px; 
        padding: 8px 20px; 
        font-weight: 700; 
        font-size: 11px; 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        margin: 0 auto; 
        cursor: pointer; }

        .bottom-nav { 
        position: fixed; 
        bottom: 0; 
        left: 0; 
        right: 0; 
        background: linear-gradient(to top, #8389f7, #a2a7fb); 
        height: 70px; 
        display: flex; 
        justify-content: center; 
        gap: 40px; 
        align-items: center; 
        z-index: 1000; 
        border-radius: 40px 40px 0 0; }

        .nav-item img { 
        width: 35px; }

        .active-boq { 
        background: #4a148c; 
        width: 75px; 
        height: 75px; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border: 5px solid #8389f7; 
        margin-top: -50px; 
        box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
        
        input.table-input { 
        width: 90%; 
        border: none; 
        background: transparent; 
        text-align: center; 
        font-family: inherit; 
        font-weight: bold; }
    </style>
</head>
<body>

    <header class="navbar-custom">
        <div class="logo-section">
            <img src="../assets/img/logo.png" alt="" class="logo-img">
            <span class="logo-text">Estimator</span>
        </div>
        <a href="logout.php" class="logout-btn">
            <div class="icon-circle"><i class="fas fa-sign-out-alt"></i></div>
            <span style="color: black; font-weight: 800;">Logout</span>
        </a>
    </header>

    <main class="container">
        <h1 class="page-title">Pembuatan BOQ <i class="fas fa-file-invoice-dollar" style="color: #3f51b5;"></i></h1>
        <a href="daftarrfq.php" class="btn-back">Kembali ke RFQ</a>

        <div class="info-card">
            <div class="info-line">Referensi : <?= $referensi ?></div>
            <div class="info-line">Proyek : <?= $proyek ?></div>
            <div class="info-line">Status BOQ : [ Draft ]</div>
        </div>

        <a href="../uploads/<?= $file_pdf ?>" target="_blank" class="btn-lihat-doc">
            Lihat Dokumen RFQ 
            <img src="https://cdn-icons-png.flaticon.com/512/2991/2991108.png" width="20">
        </a>

        <h2 class="section-subtitle">Daftar Material & Biaya</h2>

        <form id="formBOQ">
            <input type="hidden" name="id_rfq" value="<?= $id_rfq ?>">
            <div class="table-container">
                <table id="boqTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Material</th>
                            <th>QTY</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>

            <div class="action-btns">
                <button type="button" class="btn-tambah" onclick="addRow()"><i class="fas fa-plus"></i> Tambah</button>
                <button type="button" class="btn-simpan" onclick="saveDraft()">Simpan Draft</button>
            </div>

            <button type="button" class="btn-kirim" onclick="kirimKeFinance()">
                Kirim ke Finance & Manajemen 
                <i class="fas fa-save" style="background: #1a237e; color: white; padding: 4px; border-radius: 4px;"></i>
            </button>
        </form>
    </main>

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

</nav>

    <script>
        // JS untuk Tambah Baris
        function addRow() {
            const table = document.getElementById("boqTable").getElementsByTagName('tbody')[0];
            const rowCount = table.rows.length;
            const row = table.insertRow(rowCount);
            
            row.innerHTML = `
                <td>${rowCount + 1}</td>
                <td><input type="text" name="material[]" class="table-input" required></td>
                <td><input type="number" name="qty[]" class="table-input" oninput="calculate(this)" required></td>
                <td><input type="text" name="satuan[]" class="table-input" required></td>
                <td><input type="number" name="harga[]" class="table-input" oninput="calculate(this)" required></td>
                <td><input type="text" name="subtotal[]" class="table-input" readonly></td>
                <td><button type="button" onclick="this.parentElement.parentElement.remove()" style="border:none; background:none; cursor:pointer;"><i class="fas fa-trash-alt"></i></button></td>
            `;
        }

        // Hitung Subtotal Otomatis
        function calculate(element) {
            const row = element.parentElement.parentElement;
            const qty = row.querySelector('input[name="qty[]"]').value || 0;
            const harga = row.querySelector('input[name="harga[]"]').value || 0;
            const subtotal = row.querySelector('input[name="subtotal[]"]');
            subtotal.value = qty * harga;
        }

        // AJAX Simpan Draft
        function saveDraft() {
            const formData = new FormData(document.getElementById("formBOQ"));
            fetch('simpan_boq.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                Swal.fire('Berhasil!', 'Draft BOQ telah disimpan ke database.', 'success');
            });
        }

        // Pop-up Kirim ke Finance
        function kirimKeFinance() {
            Swal.fire({
                title: 'Konfirmasi Kirim',
                text: "Kirim BOQ ini ke Finance dan Manajemen?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Terkirim!', 'BOQ berhasil dikirimkan ke finance dan manajemen.', 'success');
                }
            });
        }
    </script>
</body>
</html>