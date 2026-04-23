<?php
include '../koneksi.php';
session_start();

if (isset($_GET['id'])) {
    $id_boq = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Update status di tabel boq menjadi 'Disetujui'
    $update_boq = mysqli_query($conn, "UPDATE boq SET status_boq = 'Disetujui' WHERE id_boq = '$id_boq'");

    // 2. Update atau Insert status di tabel negosiasi_harga menjadi 'Disetujui'
    // Cek dulu apakah data nego sudah ada
    $cek_nego = mysqli_query($conn, "SELECT * FROM negosiasi_harga WHERE id_boq = '$id_boq'");
    
    if (mysqli_num_rows($cek_nego) > 0) {
        mysqli_query($conn, "UPDATE negosiasi_harga SET status_nego = 'Disetujui' WHERE id_boq = '$id_boq'");
    } else {
        mysqli_query($conn, "INSERT INTO negosiasi_harga (id_boq, status_nego) VALUES ('$id_boq', 'Disetujui')");
    }

    if ($update_boq) {
        echo "<script>
                alert('Harga Final Disetujui!'); 
                window.location.href = 'riwayatnegoisasi.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>