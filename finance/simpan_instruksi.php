<?php
// Tambahkan ini di paling atas untuk melihat error jika ada
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../koneksi.php';
session_start();

// Kita cek apakah id_boq dikirim (tidak harus cek tombol 'kirim')
if (isset($_POST['id_boq'])) {
    $id_boq = mysqli_real_escape_string($conn, $_POST['id_boq']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan_instruksi']);

    // 1. Simpan ke tabel pesan_negosiasi
    // Note: saya tambahkan harga_ajuan = NULL atau 0 jika memang di DB diminta ada nilainya
    $query = "INSERT INTO pesan_negosiasi (id_boq, pengirim, isi_pesan, waktu_kirim) 
              VALUES ('$id_boq', 'finance', '$pesan', NOW())";
    
    $exec_insert = mysqli_query($conn, $query);
    
    if ($exec_insert) {
        // 2. Update status di tabel negosiasi_harga
        mysqli_query($conn, "UPDATE negosiasi_harga SET status_nego = 'Pending' WHERE id_boq = '$id_boq'");

        echo "<script>
                alert('Instruksi berhasil dikirim ke Customer Service!');
                window.location.href = 'negoisasi.php?id=$id_boq';
              </script>";
        exit;
    } else {
        // Tampilkan error jika query gagal
        die("Gagal Query Simpan: " . mysqli_error($conn));
    }
} else {
    // Jika diakses tanpa post data
    die("Data tidak lengkap. Harap kirim melalui form.");
}
?>