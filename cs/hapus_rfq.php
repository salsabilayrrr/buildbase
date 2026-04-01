<?php
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Hapus data RFQ (Data biner PDF akan ikut terhapus otomatis)
    $query = "DELETE FROM data_rfq WHERE id_rfq = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Dihapus!'); window.location.href='kelolarfq.php';</script>";
    } else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
} else {
    header("Location: kelolarfq.php");
}
?>