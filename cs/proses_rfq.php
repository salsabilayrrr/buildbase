<?php
// Aktifkan error reporting untuk melihat jika ada error tersembunyi
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
if (isset($_POST['nama_perusahaan'])) { // Menggunakan salah satu field untuk cek post
    
    // Ambil data dari form
    $nama_perusahaan = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $deskripsi       = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $email           = mysqli_real_escape_string($conn, $_POST['email_pelanggan']);
    $tanggal_rfq     = $_POST['tanggal_rfq'];

    // 3. Logika Simpan/Cek Data Pelanggan
    $query_cek_pelanggan = "SELECT id_pelanggan FROM pelanggan WHERE email = '$email' LIMIT 1";
    $hasil_cek = mysqli_query($conn, $query_cek_pelanggan);

    if (mysqli_num_rows($hasil_cek) > 0) {
        $row_pelanggan = mysqli_fetch_assoc($hasil_cek);
        $id_pelanggan  = $row_pelanggan['id_pelanggan'];
    } else {
        $query_ins_pelanggan = "INSERT INTO pelanggan (nama_perusahaan, email) VALUES ('$nama_perusahaan', '$email')";
        mysqli_query($conn, $query_ins_pelanggan) or die(mysqli_error($conn));
        $id_pelanggan = mysqli_insert_id($conn);
    }

    // 4. Proses File PDF (SESUAIKAN DENGAN name="file_pdf" di HTML)
    if (!empty($_FILES['file_pdf']['tmp_name'])) { 
        $file_tmp  = $_FILES['file_pdf']['tmp_name'];
        $file_type = $_FILES['file_pdf']['type'];
        $file_size = $_FILES['file_pdf']['size'];
        
        if ($file_type == "application/pdf") {
            // Baca isi file untuk LONGBLOB
            $file_content = addslashes(file_get_contents($file_tmp));

            // 5. Query INSERT
            $query_rfq = "INSERT INTO data_rfq (id_pelanggan, nama_perusahaan, tanggal_rfq, deskripsi, file_pendukung, status_rfq) 
                          VALUES ('$id_pelanggan', '$nama_perusahaan', '$tanggal_rfq', '$deskripsi', '$file_content', 'Baru')";

            if (mysqli_query($conn, $query_rfq)) {
                echo "<script>
                        alert('Data Berhasil Disimpan!'); 
                        window.location.href='../dashboard/cs.php';
                      </script>";
                exit();
            } else {
                // Jika error di sini, biasanya karena file terlalu besar untuk MySQL
                echo "Error Database: " . mysqli_error($conn);
                echo "<br><br><b>Tips:</b> Jika muncul error 'Server has gone away', berarti file PDF anda terlalu besar untuk settingan MySQL (max_allowed_packet).";
            }
        } else {
            echo "<script>alert('Gagal! File harus berformat PDF.'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal! File PDF tidak terdeteksi. Pastikan file terpilih dan tidak terlalu besar.'); history.back();</script>";
    }
} else {
    // Jika diakses tanpa post data
    header("Location: inputrfq.php");
}

mysqli_close($conn);
?>