<?php
include '../koneksi.php';

if (isset($_POST['simpan_laporan'])) {
    $id_boq = mysqli_real_escape_string($conn, $_POST['id_boq']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
    $keputusan = $_POST['keputusan']; 
    $id_user_finance = 6; 

    // 1. Simpan Header Laporan ke tabel laporan_keuangan
    $nama_laporan = "Evaluasi BOQ-" . sprintf("%03d", $id_boq);
    $query_laporan = "INSERT INTO laporan_keuangan (id_boq, nama_laporan, catatan_evaluasi, id_user_finance) 
                      VALUES ('$id_boq', '$nama_laporan', '$catatan', '$id_user_finance')";
    
    if (mysqli_query($conn, $query_laporan)) {
        
        // 2. Ambil data array dari form
        $items = $_POST['item'];
        $qtys  = $_POST['qty'];
        $hargas = $_POST['harga'];

        // Hapus detail lama untuk ID BoQ ini supaya tidak duplikat saat input ulang
        mysqli_query($conn, "DELETE FROM detail_boq WHERE id_boq = '$id_boq'");

        for ($i = 0; $i < count($items); $i++) {
            if (!empty($items[$i])) {
                $nama_item = mysqli_real_escape_string($conn, $items[$i]);
                $qty       = (int)$qtys[$i];
                $harga     = (double)$hargas[$i];
                $subtotal  = $qty * $harga;

                // Masukkan ke kolom nama_item
                $sql_detail = "INSERT INTO detail_boq (id_boq, nama_item, jumlah, harga_satuan, subtotal) 
                               VALUES ('$id_boq', '$nama_item', '$qty', '$harga', '$subtotal')";
                mysqli_query($conn, $sql_detail);
            }
        }

        // 3. Update Status BoQ
        $status_baru = ($keputusan == 'Disetujui') ? 'Disetujui' : 'Revisi';
        mysqli_query($conn, "UPDATE boq SET status_boq = '$status_baru' WHERE id_boq = '$id_boq'");

        echo "<script>alert('Laporan Berhasil Disimpan!'); window.location='laporankeuangan.php';</script>";
    } else {
        echo "Error Header: " . mysqli_error($conn);
    }
}
?>