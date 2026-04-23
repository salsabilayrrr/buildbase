<?php
include '../koneksi.php';

// Logika Hapus Data (Jika ada parameter hapus)
if (isset($_GET['hapus'])) {
    $id_pelanggan = mysqli_real_escape_string($conn, $_GET['hapus']);
    $delete = mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'");
    if ($delete) {
        echo "<script>
                alert('Data klien berhasil dihapus!');
                window.location.href='dataklien.php';
              </script>";
    }
}

// Logika Pencarian
$keyword = "";
if (isset($_POST['cari'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query = "SELECT * FROM pelanggan WHERE nama_perusahaan LIKE '%$keyword%' OR nama_instansi LIKE '%$keyword%' ORDER BY id_pelanggan DESC";
} else {
    $query = "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Klien - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleDataKlien.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <h2 class="text-center fw-black mb-4" style="font-weight: 900;">DATA KLIEN</h2>

        <form method="POST" class="search-container mb-4">
            <input type="text" name="keyword" class="form-control search-input" placeholder="Ketik Nama Proyek/Klien..." value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit" name="cari" class="search-icon-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <div class="table-responsive px-2">
            <table class="custom-table text-center">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 25%;">Nama Klien</th>
                        <th style="width: 25%;">Perusahaan</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>C-<?= sprintf("%02d", $row['id_pelanggan']) ?></td>
                        <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                        <td><?= $row['tipe_klien'] == 'Perusahaan' ? htmlspecialchars($row['nama_instansi']) : 'Perorangan' ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>
                            <a href="inputdataklien.php?id=<?= $row['id_pelanggan'] ?>" class="text-dark me-2">
                                <i class="fa-solid fa-pen-to-square fs-5"></i>
                            </a>
                            <a href="javascript:void(0);" onclick="hapusKlien(<?= $row['id_pelanggan'] ?>)" class="text-danger">
                                <i class="fa-solid fa-trash fs-5"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-custom mb-5">
            <i class="fa-solid fa-angles-left"></i><span>1 2 3 ..</span><i class="fa-solid fa-angles-right"></i>
        </div>
    </div>

    <a href="inputdataklien.php" class="floating-add-btn"><i class="fa-solid fa-plus"></i></a>

    <nav id="navbar" class="bottom-nav">
        <a href="inputrfq.php" class="nav-item"><i class="fa-solid fa-file-circle-check text-white" style="font-size: 24px;"></i></a>
        <a href="kelolarfq.php" class="nav-item"><i class="fa-solid fa-file-lines text-white" style="font-size: 24px;"></i></a>
        <a href="../dashboard/cs.php" class="nav-item"><i class="fa-solid fa-house text-white" style="font-size: 24px;"></i></a>
        <a href="laporannegoisasi.php" class="nav-item"><i class="fa-solid fa-handshake text-white text-2xl" ></i> </a>        
        <a href="dataklien.php" class="active-cycle"><i class="fa-solid fa-user-group" style="color: #8B93FF; font-size: 30px;"></i></a>
    </nav>

    <script>
        // Fungsi untuk konfirmasi hapus menggunakan SweetAlert2
        function hapusKlien(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data klien yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#8B93FF',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika setuju, arahkan ke URL hapus
                    window.location.href = "dataklien.php?hapus=" + id;
                }
            })
        }

        const navbar = document.getElementById('navbar');
        const inputs = document.querySelectorAll('input');

        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                navbar.style.transform = 'translateY(100px)';
            });
            input.addEventListener('blur', () => {
                navbar.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>