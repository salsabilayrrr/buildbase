<?php
// 1. Koneksi ke Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "buildbase_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Cek apakah tombol submit sudah diklik
if (isset($_POST['submit_rfq'])) {
    
    // Ambil ID (Jika ada isi = Mode Edit, Jika kosong = Mode Input Baru)
    $id_rfq = $_POST['id_rfq']; 
    
    // Ambil data dari form dan amankan dari SQL Injection
    $nama_perusahaan = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $deskripsi       = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $email           = mysqli_real_escape_string($conn, $_POST['email_pelanggan']);
    $tanggal_rfq     = $_POST['tanggal_rfq'];

    // --- BAGIAN 1: LOGIKA PELANGGAN (DIPERBAIKI) ---
    // Cek apakah kombinasi Nama Perusahaan DAN Email sudah ada
    $query_cek_pel = "SELECT id_pelanggan FROM pelanggan 
                      WHERE nama_perusahaan = '$nama_perusahaan' 
                      AND email = '$email' LIMIT 1";
    
    $hasil_cek = mysqli_query($conn, $query_cek_pel);

    if (mysqli_num_rows($hasil_cek) > 0) {
        // Jika data cocok, ambil ID pelanggan yang sudah ada
        $row_pelanggan = mysqli_fetch_assoc($hasil_cek);
        $id_pelanggan  = $row_pelanggan['id_pelanggan'];
    } else {
        // Jika data berbeda (perusahaan baru), buat data pelanggan baru
        $query_ins_pelanggan = "INSERT INTO pelanggan (nama_perusahaan, email) VALUES ('$nama_perusahaan', '$email')";
        mysqli_query($conn, $query_ins_pelanggan);
        $id_pelanggan = mysqli_insert_id($conn);
    }

    // --- BAGIAN 2: LOGIKA SIMPAN (INSERT) ATAU UPDATE ---
    
    if (!empty($id_rfq)) {
        // A. MODE UPDATE (MENGUBAH DATA LAMA)
        $sql = "UPDATE data_rfq SET 
                id_pelanggan = '$id_pelanggan', 
                nama_perusahaan = '$nama_perusahaan', 
                tanggal_rfq = '$tanggal_rfq', 
                deskripsi = '$deskripsi' 
                WHERE id_rfq = '$id_rfq'";
        
        // Update PDF hanya jika user mengunggah file baru
        if (!empty($_FILES['file_rfq']['tmp_name'])) {
            $file_content = addslashes(file_get_contents($_FILES['file_rfq']['tmp_name']));
            mysqli_query($conn, "UPDATE data_rfq SET file_pendukung = '$file_content' WHERE id_rfq = '$id_rfq'");
        }
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Data Berhasil Diperbarui!'); 
                    window.location.href='kelolarfq.php';
                  </script>";
        } else {
            echo "Error Update: " . mysqli_error($conn);
        }

    } else {
        // B. MODE INSERT (MENAMBAH DATA BARU)
        if (!empty($_FILES['file_rfq']['tmp_name'])) {
            $file_tmp = $_FILES['file_rfq']['tmp_name'];
            $file_content = addslashes(file_get_contents($file_tmp));
            
            $sql = "INSERT INTO data_rfq (id_pelanggan, nama_perusahaan, tanggal_rfq, deskripsi, file_pendukung, status_rfq) 
                    VALUES ('$id_pelanggan', '$nama_perusahaan', '$tanggal_rfq', '$deskripsi', '$file_content', 'Baru')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Data Berhasil Disimpan!'); 
                        window.location.href='../dashboard/cs.php';
                      </script>";
            } else {
                echo "Error Simpan: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('Gagal! File PDF wajib diunggah untuk data baru.'); history.back();</script>";
        }
    }
}

mysqli_close($conn);
?>