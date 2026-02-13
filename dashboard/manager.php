<?php
session_start();

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager'){
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h2>Dashboard Manajemen</h2>
<p>Selamat datang, <?php echo $_SESSION['user']['nama']; ?> 👋</p>

<a href="../logout.php" class="btn btn-danger">Logout</a>

</body>
</html>

