<?php
    session_start();
    include "koneksi.php";

    $message = "";
    $status = ""; 

    if(isset($_POST['reset'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        $user = mysqli_fetch_assoc($query);

        if($user){
            if($new_password === $confirm_password){
                $update = mysqli_query($conn, "UPDATE users SET password='$new_password' WHERE email='$email'");
                if($update){
                    $status = "success";
                    $message = "Password berhasil diperbarui! Silahkan login.";
                } else {
                    $status = "error";
                    $message = "Gagal memperbarui database.";
                }
            } else {
                $status = "error";
                $message = "Konfirmasi password tidak cocok!";
            }
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
    <title>Reset Password - BuildBase</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styleLogin.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .login-title {
            font-family: 'Roboto', sans-serif;
            font-weight: 800;     
            font-size: 17px;      
            letter-spacing: 0.8px;
            margin-top: -20px;         
            margin-bottom: 30px;  
            text-align: center;
            color: #000;
            text-transform: uppercase;
        }
        
        .success-msg, .error-msg, .back-link, label, input, button {
            font-family: 'Roboto', sans-serif;
        }

        .success-msg { 
            background: #d4edda; 
            color: #155724; 
            padding: 12px; 
            border-radius: 10px; 
            margin-bottom: 15px; 
            font-weight: 700; 
            text-align: center; 
            border: 1px solid #c3e6cb; 
            font-size: 13px;
        }

        .error-msg { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 12px; 
            border-radius: 10px; 
            margin-bottom: 15px; 
            font-weight: 700; 
            text-align: center; 
            border: 1px solid #f5c6cb; 
            font-size: 13px;
        }

        .back-link { 
            display: block; 
            text-align: center; 
            margin-top: 20px; 
            color: #4E5FE1; 
            text-decoration: none; 
            font-weight: 700; 
            font-size: 13px; 
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="device-wrapper">
        <div class="device-screen">
            <div class="header-section"></div>

            <div class="login-card">
                <h2 class="login-title">RESET PASSWORD</h2>
                
                <?php if($message != ""): ?>
                    <div class="<?php echo ($status == 'success') ? 'success-msg' : 'error-msg'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="input-group">
                        <label>Masukkan Email Terdaftar</label>
                        <input type="email" class="custom-input" placeholder="email@contoh.com" name="email" required>
                    </div>

                    <div class="input-group">
                        <label>Password Baru</label>
                        <input type="password" class="custom-input" placeholder="Minimal 6 karakter" name="new_password" required>
                    </div>

                    <div class="input-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" class="custom-input" placeholder="Ulangi password baru" name="confirm_password" required>
                    </div>

                    <button type="submit" name="reset" class="btn-login-submit">PERBARUI PASSWORD</button>
                    
                    <a href="index.php" class="back-link"> Kembali ke Halaman Login</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>