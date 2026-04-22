<?php
session_start();
include '../koneksi.php';

// Logika Pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query_sql = "SELECT dr.*, p.nama_perusahaan 
              FROM data_rfq dr 
              JOIN pelanggan p ON dr.id_pelanggan = p.id_pelanggan";

if (!empty($search)) {
    $query_sql .= " WHERE p.nama_perusahaan LIKE '%$search%' OR dr.id_rfq LIKE '%$search%'";
}

$query_sql .= " ORDER BY dr.id_rfq DESC";
$result = mysqli_query($conn, $query_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildBase - Kelola RFQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleKelolaRFQ.css">
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

    <main class="p-6">
        <h1 class="page-title text-center uppercase">Kelola Data Request For Quotation (RFQ)</h1>

        <div class="flex space-x-2 mt-6 max-w-md mx-auto">
            <form method="GET" action="" class="flex-grow flex items-center bg-light-purple px-5 py-3 rounded-2xl shadow-inner border border-black/10">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Ketik Nama Proyek/Klien..." class="bg-transparent w-full outline-none placeholder-indigo-800 text-sm font-bold text-indigo-900">
                <button type="submit"><i class="fa-solid fa-magnifying-glass text-white text-2xl"></i></button>
            </form>
            <button class="bg-light-purple px-4 rounded-2xl shadow-md border border-black/10">
                <i class="fa-solid fa-chevron-down text-black"></i>
            </button>
        </div>

        <div class="mt-8 overflow-hidden rounded-xl border-2 border-black shadow-[6px_6px_0px_#000]">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="15%">ID</th>
                        <th width="35%">Pelanggan</th>
                        <th width="20%">Tanggal</th>
                        <th width="15%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= str_pad($row['id_rfq'], 3, "0", STR_PAD_LEFT) ?></td>
                                <td class="text-left"><?= $row['nama_perusahaan'] ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal_rfq'])) ?></td>
                                <td><?= $row['status_rfq'] ?></td>
                                <td>
                                    <a href="editrfq.php?id=<?= $row['id_rfq'] ?>" class="btn-edit-action">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="py-10 text-gray-500 italic">Data tidak ditemukan...</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-start space-x-4 mt-6 font-bold text-black">
            <i class="fa-solid fa-angles-left cursor-pointer"></i>
            <span>1 2 3 ..</span>
            <i class="fa-solid fa-angles-right cursor-pointer"></i>
        </div>

        <a href="inputrfq.php" class="floating-btn shadow-xl">
            <i class="fa-solid fa-plus text-white text-4xl"></i>
        </a>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="inputrfq.php" class="nav-item"><i class="fa-solid fa-file-circle-check"></i></a>
        <a href="kelolarfq.php" class="active-cycle"><i class="fa-solid fa-file-lines"></i></a>
        <a href="../dashboard/cs.php" class="nav-item"><i class="fa-solid fa-house"></i></a>
        <a href="../cs/laporannegoisasi.php" class="nav-item"><i class="fa-solid fa-handshake text-white text-2xl" ></i></a>
        <a href="dataklien.php" class="nav-item"><i class="fa-solid fa-user-group"></i></a>
    </nav>

</body>
<script>
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
</html>