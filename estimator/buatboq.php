<?php
session_start();
// Koneksi database
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");
if (!$conn) { die("Koneksi gagal: " . mysqli_connect_error()); }

$id_rfq = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_rfq <= 0) {
    echo "<script>alert('ID RFQ tidak valid!'); window.location.href='daftarrfq.php';</script>";
    exit;
}
// Query mengambil data dari tabel 'data_rfq' sesuai dump SQL kamu
$query_header = "
    SELECT dr.id_rfq, dr.deskripsi, p.nama_perusahaan, sd.file_path 
    FROM data_rfq dr
    JOIN pelanggan p ON dr.id_pelanggan = p.id_pelanggan 
    LEFT JOIN shop_drawing sd ON dr.id_rfq = sd.id_rfq
    WHERE dr.id_rfq = $id_rfq
";
$result_header = mysqli_query($conn, $query_header);
$data_header = mysqli_fetch_assoc($result_header);

$referensi = $data_header ? "RFQ-" . str_pad($data_header['id_rfq'], 3, "0", STR_PAD_LEFT) : "-";
$proyek = $data_header ? $data_header['deskripsi'] . " (" . $data_header['nama_perusahaan'] . ")" : "Data tidak ditemukan";
$file_pdf = $data_header['file_path'] ?? '#';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembuatan BOQ - BuildBase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleBuatBOQ.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <header class="navbar-custom">
        <div class="flex items-center"> 
            <img src="../assets/img/logo.png" alt="Logo" style="width: 60px; height: auto;">
            <span class="text-2xl font-black text-black tracking-tighter -ml-2">Estimator</span>
        </div>
        <a href="../logout.php" class="logout-btn">
            <div class="icon-circle-logout">
                <i class="fas fa-sign-out-alt text-white"></i>
            </div>
            <span class="text-black font-extrabold">Logout</span>
        </a>
    </header>

    <main class="container mx-auto px-4">
        <h1 class="page-title mt-6 text-center font-black text-2xl uppercase tracking-tighter">
            Pembuatan BOQ <i class="fas fa-file-invoice-dollar text-[#8B93FF]"></i>
        </h1>

        <div class="info-card">
            <div class="info-line">Referensi : <?= $referensi ?></div>
            <div class="info-line">Proyek : <?= $proyek ?></div>
            <div class="info-line">Status BOQ : <span style="color: #1a237e;">[ Draft ]</span></div>
        </div>

        <div class="text-center mb-6">
            <?php if ($file_pdf != '#'): ?>
                <a href="../uploads/<?= htmlspecialchars($file_pdf) ?>" target="_blank" class="btn-lihat-doc">
                    <i class="fa-solid fa-file-pdf text-red-600 text-xl"></i> Lihat Dokumen RFQ
                </a>
            <?php else: ?>
                <button class="btn-lihat-doc" disabled style="opacity: 0.5;">Tidak Ada Dokumen</button>
            <?php endif; ?>
        </div>

        <form id="formBOQ">
        <input type="hidden" name="id_rfq" value="<?= htmlspecialchars($id_rfq) ?>">
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
                        <tr>
                            <td>1</td>
                            <td><input type="text" name="material[]" class="table-input" required></td>
                            <td><input type="number" name="qty[]" class="table-input" oninput="calculate(this)" required></td>
                            <td><input type="text" name="satuan[]" class="table-input" required></td>
                            <td><input type="number" name="harga[]" class="table-input" oninput="calculate(this)" required></td>
                            <td><input type="number" name="subtotal[]" class="table-input bg-gray-50" readonly></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-center gap-4 mt-6">
                <button type="button" class="btn-tambah" onclick="addRow()"><i class="fas fa-plus"></i> Tambah Baris</button>
            </div>

            <button type="button" class="btn-kirim" onclick="simpanData()">
                SIMPAN KE DATABASE <i class="fas fa-save ml-2"></i>
            </button>
        </form>
    </main>

    <nav id="navbar" class="bottom-nav">
        <a href="verif.php" class="nav-item"><i class="fa-solid fa-file-circle-check"></i></a>
        <a href="../dashboard/estimator.php" class="nav-item"><i class="fa-solid fa-house"></i></a>
        <a href="daftarrfq.php" class="nav-item"><i class="fa-solid fa-clipboard-check"></i></a>
        <a href="buatboq.php" class="home-button"><i class="fa-solid fa-calculator"></i></a>
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
                <td><input type="number" name="subtotal[]" class="table-input bg-gray-50" readonly></td>
                <td><button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-600"><i class="fas fa-trash-alt"></i></button></td>
            `;
        }

        function calculate(element) {
            const row = element.parentElement.parentElement;
            const qty = parseFloat(row.querySelector('input[name="qty[]"]').value) || 0;
            const harga = parseFloat(row.querySelector('input[name="harga[]"]').value) || 0;
            const subtotal = row.querySelector('input[name="subtotal[]"]');
            subtotal.value = qty * harga; 
        }

        function simpanData() {
            const formData = new FormData(document.getElementById("formBOQ"));
            
            Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

            fetch('simpan_boq.php', { method: 'POST', body: formData })
            .then(response => response.text())
            .then(data => { 
                if(data.trim() === "success") {
                    Swal.fire('Berhasil!', 'Data BOQ telah tersimpan di database.', 'success')
                    .then(() => { window.location.href = 'daftarrfq.php'; });
                } else {
                    Swal.fire('Gagal Simpan', data, 'error');
                }
            });
        }
    </script>
</body>
</html>