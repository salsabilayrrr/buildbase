<?php
include "koneksi.php";
$message = ""; $status = "";

$email_url = $_GET['email'] ?? '';
$token_url = $_GET['token'] ?? '';

// Validasi Token
$query = mysqli_query($conn, "SELECT * FROM password_resets WHERE email='$email_url' AND token='$token_url'");
$reset_data = mysqli_fetch_assoc($query);

if(!$reset_data || strtotime($reset_data['exp_date']) < time()){
    die("<center style='margin-top:100px; font-family:Plus Jakarta Sans, sans-serif;'><h2>Link Expired!</h2><a href='forgot_password.php'>Minta Link Baru</a></center>");
}

if(isset($_POST['update_pass'])){
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if(strlen($new_password) < 6){
        $status = "error"; $message = "Minimal 6 karakter!";
    } else if($new_password === $confirm_password){
        
        // Simpan sebagai teks biasa (TIDAK DI-HASH)
        $update = mysqli_query($conn, "UPDATE users SET password='$new_password' WHERE email='$email_url'");
        mysqli_query($conn, "DELETE FROM password_resets WHERE email='$email_url'");

        echo "<script>alert('Password Berhasil Diperbarui!'); window.location.href='index.php';</script>";
        exit;
    } else {
        $status = "error"; $message = "Konfirmasi tidak cocok!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Password - BuildBase</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styleLogin.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Memaksa kartu naik ke atas */
        .login-card {
            margin-top: -100px !important; 
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div class="device-wrapper">
        <div class="device-screen">
            <div class="header-section"></div>

            <div class="login-card">
                <h2 class="login-title">PASSWORD BARU</h2>
                
                <?php if($message != ""): ?>
                    <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 12px; margin-bottom: 15px; font-weight: 700; text-align: center; font-size: 11px; border: 2px solid black;">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="input-group">
                        <label style="display:block; font-weight:800; font-size:11px; text-transform:uppercase; margin-bottom:5px; margin-left:5px;">Password Baru</label>
                        <input type="password" class="custom-input" name="new_password" placeholder="Masukkan password" required 
                               style="width:100%; padding:12px; border-radius:15px; border:2px solid black; margin-bottom:15px; font-weight:600; outline:none;">
                    </div>

                    <div class="input-group">
                        <label style="display:block; font-weight:800; font-size:11px; text-transform:uppercase; margin-bottom:5px; margin-left:5px;">Konfirmasi</label>
                        <input type="password" class="custom-input" name="confirm_password" placeholder="Ulangi password" required 
                               style="width:100%; padding:12px; border-radius:15px; border:2px solid black; margin-bottom:20px; font-weight:600; outline:none;">
                    </div>

                    <button type="submit" name="update_pass" 
                            style="width:100%; padding:15px; background:#5c7cfa; color:white; border:2px solid black; border-radius:50px; font-weight:900; box-shadow:4px 4px 0px black; cursor:pointer; text-transform:uppercase;">
                        SIMPAN PASSWORD
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>