<?php
include '../koneksi.php';

if (isset($_POST['kirim_nego'])) {
    // Ambil dan bersihkan input
    $id_boq = mysqli_real_escape_string($conn, $_POST['id_boq']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan_nego']); 

    // --- VALIDASI PENTING ---
    // Cek apakah ID BoQ ini benar-benar ada di tabel boq
    $cek_boq = mysqli_query($conn, "SELECT id_boq FROM boq WHERE id_boq = '$id_boq'");
    
    if (mysqli_num_rows($cek_boq) == 0) {
        // Jika ID tidak ditemukan, tampilkan error dan stop
        echo "<script>
                alert('Error: ID BoQ ($id_boq) tidak ditemukan di database! Pastikan data BoQ sudah dibuat oleh Estimator.');
                history.back();
              </script>";
        exit;
    }

    // Jika ID ditemukan, lanjutkan simpan pesan
    $query = "INSERT INTO pesan_negosiasi (id_boq, pengirim, isi_pesan) 
              VALUES ('$id_boq', 'finance', '$pesan')";

    if (mysqli_query($conn, $query)) {
        // Update status BoQ menjadi Revisi
        mysqli_query($conn, "UPDATE boq SET status_boq = 'Revisi' WHERE id_boq = '$id_boq'");
        
        // Simpan/Update ke tabel negosiasi_harga (Gunakan REPLACE agar jika sudah ada datanya, dia update, jika belum dia insert)
        mysqli_query($conn, "REPLACE INTO negosiasi_harga (id_boq, status_nego) VALUES ('$id_boq', 'Pending')");

        echo "<script>
                alert('Instruksi negosiasi berhasil dikirim ke CS!');
                window.location='riwayatnegoisasi.php';
              </script>";
    } else {
        echo "Error Database: " . mysqli_error($conn);
    }
}
?>