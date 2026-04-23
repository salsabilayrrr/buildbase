<?php
include "koneksi.php";
$message = "";
$status = "";

if(isset($_POST['submit_email'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        $token = bin2hex(random_bytes(32));
        $exp_date = date("Y-m-d H:i:s", strtotime('+30 minutes'));

        mysqli_query($conn, "DELETE FROM password_resets WHERE email='$email'");
        mysqli_query($conn, "INSERT INTO password_resets (email, token, exp_date) VALUES ('$email', '$token', '$exp_date')");

        $status = "success";
        $reset_link = "reset_password_final.php?email=$email&token=$token";
        $message = "Link pemulihan ditemukan:<br><a href='$reset_link' style='color:#5c7cfa; text-decoration:underline;'>KLIK UNTUK RESET PASSWORD</a>";
    } else {
        $status = "error";
        $message = "Email tidak terdaftar dalam sistem!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - BuildBase</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styleLogin.css">
</head>
<body>
    <div class="device-wrapper">
        <div class="device-screen">
            <div class="header-section"></div>

            <div class="login-card">
                <h2 class="login-title">LUPA PASSWORD</h2>
                
                <?php if($message != ""): ?>
                    <div style="background: <?= ($status == 'success') ? '#d4edda' : '#f8d7da' ?>; 
                                color: <?= ($status == 'success') ? '#155724' : '#721c24' ?>; 
                                padding: 12px; border-radius: 15px; margin-bottom: 20px; font-weight: 700; text-align: center; font-size: 12px; border: 2px solid black;">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="input-group">
                        <label style="display:block; font-weight:800; font-size:11px; text-transform:uppercase; margin-bottom:8px;">Masukkan Email Terdaftar</label>
                        <input type="email" class="custom-input" placeholder="email@contoh.com" name="email" required 
                               style="width:100%; padding:12px; border-radius:15px; border:2px solid black; margin-bottom:20px; font-weight:600; outline:none;">
                    </div>

                    <button type="submit" name="submit_email" class="btn-login-submit" 
                            style="width:100%; padding:15px; background:#8B93FF; color:white; border:2px solid black; border-radius:50px; font-weight:900; box-shadow:4px 4px 0px black; cursor:pointer;">
                        MINTA LINK RESET
                    </button>
                    
                    <a href="index.php" style="display:block; text-align:center; margin-top:20px; color:#8B93FF; text-decoration:none; font-weight:800; font-size:13px;">
                        Kembali ke Login
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>