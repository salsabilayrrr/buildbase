<?php
session_start();
include "koneksi.php";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if($user && $password == $user['password']){
        $_SESSION['user'] = $user;
        
        switch($user['role']){
            case 'cs': header("Location: dashboard/cs.php"); break;
            case 'manager': header("Location: dashboard/manager.php"); break;
            case 'estimator': header("Location: dashboard/estimator.php"); break;
            case 'drafter': header("Location: dashboard/drafter.php"); break;
            case 'engineer': header("Location: dashboard/engineer.php"); break;
            case 'finance': header("Location: dashboard/finance.php"); break;
            case 'qc': header("Location: dashboard/qc.php"); break;
        }
    } else {
        echo "Login gagal";
    }
}
?>
