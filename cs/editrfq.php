<?php
session_start();
// Koneksi Database
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");
if (!$conn) { die("Koneksi gagal: " . mysqli_connect_error()); }

// 1. AMBIL DATA LAMA BERDASARKAN ID
$id_rfq = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_rfq <= 0) {
    echo "<script>alert('ID RFQ tidak valid!'); window.location.href='../dashboard/cs.php';</script>";
    exit;
}

$query = mysqli_query($conn, "SELECT dr.*, p.nama_perusahaan 
                               FROM data_rfq dr 
                               JOIN pelanggan p ON dr.id_pelanggan = p.id_pelanggan 
                               WHERE dr.id_rfq = $id_rfq");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location.href='../dashboard/cs.php';</script>";
    exit;
}

// 2. PROSES SIMPAN PERUBAHAN
if (isset($_POST['save_update'])) {
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $status = mysqli_real_escape_string($conn, $_POST['status_rfq']);
    $tanggal = $_POST['tanggal_rfq'];

    $update_sql = "UPDATE data_rfq SET 
                   deskripsi = '$deskripsi', 
                   status_rfq = '$status', 
                   tanggal_rfq = '$tanggal' 
                   WHERE id_rfq = $id_rfq";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>
                alert('Perubahan Berhasil Disimpan!');
                window.location.href='../dashboard/cs.php';
              </script>";
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
    <title>BuildBase - Edit RFQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800;900&family=Pacifico&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8faff;
            margin: 0;
        }

        .navbar-custom {
            background-color: #8B93FF;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            letter-spacing: -0.05em;
        }

        .halo-text {
            font-family: 'Pacifico', cursive;
            color: #1e1b4b;
        }

        .form-container {
            background-color: #C2C7FF;
            border: 2px solid #000;
            border-radius: 30px;
            box-shadow: 6px 6px 0px #000;
        }

        input, textarea, select {
            border: 1.5px solid #000 !important;
            font-weight: 700;
        }

        .btn-save {
            background-color: #8B93FF;
            border: 2px solid #000;
            box-shadow: 4px 4px 0px #000;
            transition: all 0.2s;
        }

        .btn-save:active {
            box-shadow: 0px 0px 0px #000;
            transform: translate(4px, 4px);
        }
    </style>
</head>
<body>

    <header class="navbar-custom">
        <div class="flex items-center"> 
            <img src="../assets/img/logo.png" alt="BuildBase" class="w-16 h-16">
            <span class="text-2xl header-title text-black -ml-2">BuildBase</span>
        </div>
        <div class="font-black text-black uppercase italic text-sm">Edit Mode</div>
    </header>

    <main class="p-6">
        <h1 class="halo-text text-3xl text-center mb-6">Edit Request</h1>

        <div class="form-container p-6 max-w-lg mx-auto">
            <form action="" method="POST" class="space-y-4">
                
                <div class="text-center mb-4">
                    <span class="bg-white px-4 py-1 rounded-full border-2 border-black font-black text-xs">
                        RFQ ID: #<?= str_pad($data['id_rfq'], 3, "0", STR_PAD_LEFT) ?>
                    </span>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase mb-1">Pelanggan</label>
                    <input type="text" value="<?= $data['nama_perusahaan'] ?>" class="w-full p-3 rounded-2xl bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase mb-1">Tanggal Request</label>
                    <input type="date" name="tanggal_rfq" value="<?= $data['tanggal_rfq'] ?>" class="w-full p-3 rounded-2xl outline-none focus:bg-white" required>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase mb-1">Deskripsi Proyek</label>
                    <textarea name="deskripsi" rows="4" class="w-full p-3 rounded-2xl outline-none focus:bg-white" required><?= $data['deskripsi'] ?></textarea>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase mb-1">Status Proyek</label>
                    <select name="status_rfq" class="w-full p-3 rounded-2xl outline-none focus:bg-white">
                        <option value="Baru" <?= $data['status_rfq'] == 'Baru' ? 'selected' : '' ?>>Baru</option>
                        <option value="Proses" <?= $data['status_rfq'] == 'Proses' ? 'selected' : '' ?>>Proses (Diteruskan)</option>
                        <option value="Selesai" <?= $data['status_rfq'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="Batal" <?= $data['status_rfq'] == 'Batal' ? 'selected' : '' ?>>Batal</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="../dashboard/cs.php" class="flex-1 bg-white text-center py-3 rounded-2xl font-black border-2 border-black active:scale-95 transition">
                        Batal
                    </a>
                    <button type="submit" name="save_update" class="flex-1 btn-save py-3 rounded-2xl font-black text-black uppercase tracking-tight">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </main>

</body>
</html>