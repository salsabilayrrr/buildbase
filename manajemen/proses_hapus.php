<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "buildbase_db");

if (!$conn) { die("Koneksi gagal: " . mysqli_connect_error()); }
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager'){
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM users WHERE id = $id";
    $delete = mysqli_query($conn, $query);

    if ($delete) {
        header("Location: kelolaPengguna.php?status=sukses");
        exit;
    } else {
        header("Location: kelolaPengguna.php?status=gagal");
        exit;
    }
} else {
    header("Location: kelolaPengguna.php");
    exit;
}
?>