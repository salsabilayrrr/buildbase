<?php
include '../koneksi.php';

if (isset($_POST['save_klien'])) {
    $id = $_POST['id_pelanggan'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $tipe = $_POST['tipe_klien'];
    $instansi = mysqli_real_escape_string($conn, $_POST['nama_instansi']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telp = mysqli_real_escape_string($conn, $_POST['nomor_telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    if (!empty($id)) {
        // Mode Update
        $sql = "UPDATE pelanggan SET tipe_klien='$tipe', nama_perusahaan='$nama', nama_instansi='$instansi', email='$email', nomor_telepon='$telp', alamat='$alamat' WHERE id_pelanggan='$id'";
    } else {
        // Mode Insert
        $sql = "INSERT INTO pelanggan (tipe_klien, nama_perusahaan, nama_instansi, email, nomor_telepon, alamat) VALUES ('$tipe', '$nama', '$instansi', '$email', '$telp', '$alamat')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data Berhasil Disimpan!'); window.location='dataklien.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>