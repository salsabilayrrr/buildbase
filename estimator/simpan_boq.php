<?php
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_rfq = $_POST['id_rfq'];
    $materials = $_POST['material'];
    $qtys = $_POST['qty'];
    $satuans = $_POST['satuan'];
    $hargas = $_POST['harga'];
    $subtotals = $_POST['subtotal'];

    $total_biaya = array_sum($subtotals);
    $id_estimator = 3; // Contoh ID Jeno dari tabel users

    // 1. Simpan ke tabel BOQ
    $sql_boq = "INSERT INTO boq (id_rfq, id_user_estimator, total_biaya, status_boq) VALUES ('$id_rfq', '$id_estimator', '$total_biaya', 'Draft')";
    if (mysqli_query($conn, $sql_boq)) {
        $id_boq_baru = mysqli_insert_id($conn);

        // 2. Simpan Detail BOQ
        foreach ($materials as $index => $material_name) {
            // Kita asumsikan material baru didaftarkan atau dicocokkan namanya
            // Sederhananya, kita masukkan ke detail_boq
            $qty = $qtys[$index];
            $harga = $hargas[$index];
            $sub = $subtotals[$index];
            
            $sql_detail = "INSERT INTO detail_boq (id_boq, jumlah, harga_satuan, subtotal) VALUES ('$id_boq_baru', '$qty', '$harga', '$sub')";
            mysqli_query($conn, $sql_detail);
        }
        echo "success";
    }
}
?>