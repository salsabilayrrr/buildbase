<?php
include '../koneksi.php';
header('Content-Type: application/json');

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT b.status_boq, r.deskripsi, p.nama_perusahaan 
                              FROM boq b 
                              JOIN data_rfq r ON b.id_rfq = r.id_rfq 
                              JOIN pelanggan p ON r.id_pelanggan = p.id_pelanggan 
                              WHERE b.id_boq = '$id'");

if(mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);
    $data['status'] = 'success';
    echo json_encode($data);
} else {
    echo json_encode(['status' => 'error']);
}
?>