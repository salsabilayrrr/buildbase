<?php
include '../koneksi.php';

if (isset($_POST['aksi']) && $_POST['aksi'] == 'setuju') {
    $id_boq = $_POST['id_boq'];
    
    // Update status di tabel boq
    $update = mysqli_query($conn, "UPDATE boq SET status_boq = 'Disetujui' WHERE id_boq = '$id_boq'");
    
    if ($update) {
        echo "<script>alert('BoQ Berhasil Disetujui!'); window.location.href = 'riwayatnegoisasi.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>