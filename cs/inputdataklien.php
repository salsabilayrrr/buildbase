<?php
include '../koneksi.php';
$id_pel = ""; $nama = ""; $tipe = "Perorangan"; $instansi = ""; $email = ""; $telp = ""; $alamat = ""; $is_edit = false;

if (isset($_GET['id'])) {
    $is_edit = true;
    $id_pel = mysqli_real_escape_string($conn, $_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan = '$id_pel'");
    $data = mysqli_fetch_assoc($query);
    if($data) {
        $nama = $data['nama_perusahaan']; // Digunakan sebagai Nama Lengkap
        $tipe = $data['tipe_klien'];
        $instansi = $data['nama_instansi'];
        $email = $data['email'];
        $telp = $data['nomor_telepon'];
        $alamat = $data['alamat'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Klien - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputDataKlien.css">
</head>
<body>
   <header class="navbar-custom">
    <div class="navbar-left"> 
        <img src="../assets/img/logo.png" alt="BuildBase" class="logo-img">
        <span class="navbar-brand-text">Customer Service</span>
    </div>

    <a href="../logout.php" class="logout-btn">
        <div class="icon-circle">
            <i class="fa-solid fa-right-from-bracket logout-icon-fa"></i>
        </div>
        <span class="logout-text">Logout</span>
    </a>
</header>

    <div class="container mt-4 mb-5">
        <h2 class="text-center fw-black mb-4" style="font-weight: 900;">INPUT DATA KLIEN</h2>
        <div class="main-card p-4" style="background-color: #C2C7FF; border-radius: 30px;">
            <p class="fw-bold mb-3">FORM DATA KLIEN:</p>
            <form action="proses_klien.php" method="POST">
                <input type="hidden" name="id_pelanggan" value="<?= $id_pel ?>">
                <div class="mb-3">
                    <input type="text" name="nama" class="form-control custom-input" placeholder="Nama Lengkap *" value="<?= $nama ?>" required>
                </div>
                <div class="mb-3 position-relative">
                    <select name="tipe_klien" id="tipe_klien" class="form-select custom-input" required onchange="toggleInstansi()">
                        <option value="Perorangan" <?= $tipe == 'Perorangan' ? 'selected' : '' ?>>Perorangan</option>
                        <option value="Perusahaan" <?= $tipe == 'Perusahaan' ? 'selected' : '' ?>>Perusahaan</option>
                    </select>
                </div>
                <div class="mb-3" id="box_instansi" style="<?= $tipe == 'Perusahaan' ? '' : 'display:none' ?>">
                    <input type="text" name="nama_instansi" id="nama_instansi" class="form-control custom-input" placeholder="Nama Instansi *" value="<?= $instansi ?>">
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control custom-input" placeholder="Email *" value="<?= $email ?>" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="nomor_telepon" class="form-control custom-input" placeholder="Nomor Telepon *" value="<?= $telp ?>" required>
                </div>
                <div class="mb-3">
                    <textarea name="alamat" class="form-control custom-input" placeholder="Alamat Fisik *" rows="3" required><?= $alamat ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="dataklien.php" class="btn btn-primary rounded-pill px-4" style="background-color: #5c7cfa; border:none;">Batal</a>
                    <button type="submit" name="save_klien" class="btn btn-primary rounded-pill px-4" style="background-color: #1e1b4b; border:none;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleInstansi() {
            var tipe = document.getElementById('tipe_klien').value;
            var box = document.getElementById('box_instansi');
            var input = document.getElementById('nama_instansi');
            if (tipe === 'Perusahaan') {
                box.style.display = 'block';
                input.required = true;
            } else {
                box.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        }
    </script>
</body>
</html>