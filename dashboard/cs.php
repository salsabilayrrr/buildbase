<?php
session_start();
// Koneksi Database
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");
if (!$conn) { die("Koneksi gagal: " . mysqli_connect_error()); }

// 1. Ambil Statistik Data RFQ secara Dinamis
// RFQ Masuk (Total semua di tabel data_rfq)
$q_masuk = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_rfq");
$rfq_masuk = mysqli_fetch_assoc($q_masuk)['total'];

// Diteruskan ke Estimator (Berdasarkan status di tabel data_rfq atau keberadaan di tabel boq)
// Contoh: Status 'Proses' dianggap sudah diteruskan
$q_diteruskan = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_rfq WHERE status_rfq != 'Baru'");
$rfq_diteruskan = mysqli_fetch_assoc($q_diteruskan)['total'];

// 2. Logika Searching
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query_list = "SELECT dr.*, p.nama_perusahaan as nama_klien 
               FROM data_rfq dr 
               JOIN pelanggan p ON dr.id_pelanggan = p.id_pelanggan";

if (!empty($search)) {
    $query_list .= " WHERE dr.deskripsi LIKE '%$search%' OR p.nama_perusahaan LIKE '%$search%'";
}
$query_list .= " ORDER BY dr.id_rfq DESC";

$result_rfq = mysqli_query($conn, $query_list);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildBase - Customer Service Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleDashboardCs.css">
</head>
<body>
    <header class="navbar-custom">
        <div class="flex items-center"> 
            <img src="../assets/img/logo.png" alt="BuildBase" class="w-20 h-20">
            <span class="text-2xl font-black text-black tracking-tighter -ml-2">BuildBase</span>
        </div>

        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle">
                <i class="fa-solid fa-right-from-bracket logout-icon-fa"></i>
            </div>
            <span class="logout-text">Logout</span>
        </a>
    </header>

    <main class="p-6 space-y-6">
        <h1 class="halo-text text-3xl text-center mt-4">Halo Customer Service</h1>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-light-purple p-4 rounded-[30px] shadow-md flex flex-col items-center">
                <img src="../assets/img/cs2.png" alt="RFQ" class="w-16 h-18 mb-2">
                <p class="font-black text-black text-xs text-center"><?= $rfq_masuk ?> RFQ Masuk</p>
            </div>
            <div class="bg-light-purple p-4 rounded-[30px] shadow-md flex flex-col items-center">
                <img src="../assets/img/cs1.png" alt="Estimator" class="w-16 h-18 mb-2">
                <p class="font-black text-black text-xs text-center leading-tight"><?= $rfq_diteruskan ?> Diteruskan ke Estimator</p>
            </div>
        </div>

        <a href="../cs/inputrfq.php" class="block">
            <button class="bg-btn-purple w-full py-4 rounded-2xl flex items-center justify-center space-x-3 shadow-md active:scale-95 transition">
                <div class="bg-white w-8 h-8 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-plus text-[#B2B9FF] text-xl"></i>
                </div>
                <span class="font-black text-black text-lg">Tambahkan RFQ Baru</span>
            </button>
        </a>

        <form method="GET" action="" class="flex space-x-2">
            <div class="bg-light-purple flex-grow flex items-center px-5 py-3 rounded-2xl shadow-inner border border-black/10">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Ketik Nama Proyek/Klien..." class="bg-transparent w-full outline-none placeholder-indigo-800 text-sm font-bold text-indigo-900">
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass text-white text-2xl"></i>
                </button>
            </div>
            <a href="dashboard.php" class="bg-light-purple px-4 flex items-center rounded-2xl shadow-md">
                <i class="fa-solid fa-rotate-right text-black"></i>
            </a>
        </form>

        <div class="space-y-3">
            <h2 class="font-black text-center text-black tracking-tight text-lg uppercase">Daftar Request For Quotation (RFQ)</h2>
            <div class="overflow-x-auto rounded-lg shadow-sm border border-black/5">
                <table class="custom-table w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($result_rfq) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result_rfq)): ?>
                                <tr>
                                    <td><?= str_pad($row['id_rfq'], 3, "0", STR_PAD_LEFT) ?></td>
                                    <td class="text-left font-bold"><?= $row['nama_klien'] ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal_rfq'])) ?></td>
                                    <td>
                                        <span class="px-2 py-1 rounded-lg text-[10px] font-black <?= $row['status_rfq'] == 'Baru' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' ?>">
                                            <?= $row['status_rfq'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="../cs/editrfq.php?id=<?= $row['id_rfq'] ?>">
                                            <i class="fa-solid fa-pencil text-white bg-indigo-500 p-2 rounded-lg hover:bg-indigo-700"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500 italic">Data tidak ditemukan...</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="../cs/inputrfq.php" class="nav-item">
            <i class="fa-solid fa-file-circle-check text-white text-2xl"></i>
        </a>
        <a href="../cs/kelolarfq.php" class="nav-item">
            <i class="fa-solid fa-file-lines text-white text-2xl"></i>
        </a>
        <a href="dashboard.php" class="home-button">
            <i class="fa-solid fa-house text-[#8B93FF] text-3xl"></i>
        </a>
        <a href="../cs/laporannegoisasi.php" class="nav-item">
            <i class="fa-solid fa-handshake text-white text-2xl" ></i>
        </a>
        <a href="../cs/dataklien.php" class="nav-item">
            <i class="fa-solid fa-user-group text-white text-2xl"></i>
        </a>
    </nav>

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
</body>
</html>