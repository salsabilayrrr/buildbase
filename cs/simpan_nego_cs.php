<?php
include '../koneksi.php';

if (isset($_POST['id_boq'])) {
    $id_boq = mysqli_real_escape_string($conn, $_POST['id_boq']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan_klien']);

    // Simpan pesan dari CS/Customer
    $query = "INSERT INTO pesan_negosiasi (id_boq, pengirim, isi_pesan, waktu_kirim) 
              VALUES ('$id_boq', 'customer', '$pesan', NOW())";
    
    if (mysqli_query($conn, $query)) {
        // Update status nego di tabel negosiasi_harga menjadi Pending kembali agar dibaca Finance
        mysqli_query($conn, "UPDATE negosiasi_harga SET status_nego = 'Pending' WHERE id_boq = '$id_boq'");
        
        echo "<script>alert('Berhasil mengirim hasil nego ke Finance!'); window.location.href = 'laporannegoisasi.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>