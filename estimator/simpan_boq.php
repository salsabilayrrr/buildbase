<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if (!$conn) { die("Koneksi Database Gagal"); }

// 1. Ambil data dengan proteksi ekstra
$id_rfq = isset($_POST['id_rfq']) ? intval($_POST['id_rfq']) : 0;
$id_user = $_SESSION['id'] ?? 3; // Default Jeno
$materials = $_POST['material'] ?? [];
$qtys = $_POST['qty'] ?? [];
$satuans = $_POST['satuan'] ?? [];
$hargas = $_POST['harga'] ?? [];
$subtotals = $_POST['subtotal'] ?? [];

// VALIDASI KRITIKAL: Cek apakah ID RFQ benar-benar ada di tabel data_rfq
$cek_rfq = mysqli_query($conn, "SELECT id_rfq FROM data_rfq WHERE id_rfq = $id_rfq");
if (mysqli_num_rows($cek_rfq) == 0) {
    die("Gagal: ID RFQ ($id_rfq) tidak ditemukan di database. Pastikan Anda masuk melalui halaman Daftar RFQ.");
}

if (empty($materials)) {
    die("Gagal: Tidak ada material yang diinput.");
}

$total_biaya = array_sum($subtotals);

mysqli_begin_transaction($conn);

// ... (bagian atas script tetap sama sampai mysqli_begin_transaction)

try {
    // 1. INSERT ke tabel boq (Header)
    $sql_boq = "INSERT INTO boq (id_rfq, id_user_estimator, total_biaya, status_boq, tanggal_dibuat) 
                VALUES ('$id_rfq', '$id_user', '$total_biaya', 'Draft', NOW())";
    
    if (!mysqli_query($conn, $sql_boq)) {
        throw new Exception("Gagal simpan header BOQ");
    }

    $id_boq_induk = mysqli_insert_id($conn);

    // 2. Loop Material & Detail
    foreach ($materials as $i => $nama_m) {
        if (empty($nama_m)) continue;

        // Bersihkan input agar tidak ada spasi atau karakter aneh yang bikin gagal cocok
        $m_nama = trim(mysqli_real_escape_string($conn, $nama_m));
        $m_satuan = trim(mysqli_real_escape_string($conn, $satuans[$i]));
        $m_qty = floatval($qtys[$i]);
        $m_harga = floatval($hargas[$i]);
        $m_sub = floatval($subtotals[$i]);

        // --- PROSES MATERIAL (Agar id_material tidak NULL) ---
        // Cek apakah material "Besi" sudah ada (pakai LIKE agar lebih fleksibel)
        $res_m = mysqli_query($conn, "SELECT id_material FROM material WHERE nama_material = '$m_nama' LIMIT 1");
        
        if ($res_m && mysqli_num_rows($res_m) > 0) {
            // Jika ada, ambil ID-nya
            $row_m = mysqli_fetch_assoc($res_m);
            $id_material = $row_m['id_material'];
        } else {
            // Jika TIDAK ada, WAJIB insert ke tabel material dulu
            $sql_ins_mat = "INSERT INTO material (nama_material, satuan, stok) VALUES ('$m_nama', '$m_satuan', 0)";
            if(mysqli_query($conn, $sql_ins_mat)) {
                $id_material = mysqli_insert_id($conn);
            } else {
                throw new Exception("Gagal mendaftarkan material baru: " . $m_nama);
            }
        }

        // 3. INSERT ke tabel detail_boq (Menggunakan id_material yang baru didapat)
        // Pastikan kolom id_material di tabel detail_boq tidak NULL
        $sql_det = "INSERT INTO detail_boq (id_boq, id_material, jumlah, harga_satuan, subtotal) 
                    VALUES ('$id_boq_induk', '$id_material', '$m_qty', '$m_harga', '$m_sub')";
        
        if (!mysqli_query($conn, $sql_det)) {
            throw new Exception("Gagal simpan rincian Besi/Material: " . mysqli_error($conn));
        }
    }

    mysqli_commit($conn);
    echo "success";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error: " . $e->getMessage();
}