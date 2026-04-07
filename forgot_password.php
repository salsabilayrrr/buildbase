<?php
    session_start();
    include "koneksi.php";

    $message = "";
    $status = ""; // Untuk menentukan warna alert (error/success)

    if(isset($_POST['reset'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        // 1. Cek apakah email terdaftar
        $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        $user = mysqli_fetch_assoc($query);

        if($user){
            if($new_password === $confirm_password){
                // 2. Update Password di database
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
        /* Tambahan CSS khusus untuk pesan status */
        .success-msg { background: #d4edda; color: #155724; padding: 10px; border-radius: 10px; margin-bottom: 15px; font-weight: bold; text-align: center; border: 1px solid #c3e6cb; }
        .error-msg { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 10px; margin-bottom: 15px; font-weight: bold; text-align: center; border: 1px solid #f5c6cb; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #1e1b4b; text-decoration: none; font-weight: bold; font-size: 0.9rem; }
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