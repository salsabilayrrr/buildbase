<?php
    session_start();
    include "koneksi.php";

    $error = ""; 

    if(isset($_POST['login'])){
        $role = $_POST['role'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $email = mysqli_real_escape_string($conn, $email);
        $role = mysqli_real_escape_string($conn, $role);

        $query = mysqli_query($conn, 
            "SELECT * FROM users WHERE email='$email' AND role='$role'"
        );

        $user = mysqli_fetch_assoc($query);

        if($user){
            if($password == $user['password']){
                $_SESSION['user'] = $user;
                header("Location: dashboard/".$user['role'].".php");
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Email atau Role tidak ditemukan!";
        }
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BuildBase</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styleLogin.css">
</head>
<body>
    <div class="device-wrapper">
        <div class="device-screen">
            <div class="header-section"></div>

            <div class="login-card">
                <h2 class="login-title">LOGIN</h2>
                
                <?php if($error != ""): ?>
                    <div class="error-msg"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="input-group">
                        <label>Role</label>
                        <select class="custom-input" name="role" required>
                            <option value="">Select Role</option>
                            <option value="cs">Customer Service</option>
                            <option value="estimator">Estimator</option>
                            <option value="drafter">Drafter</option>
                            <option value="engineer">Engineer</option>
                            <option value="finance">Finance</option>
                            <option value="manager">Manajer</option>
                            <option value="qc">Quality Control</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" class="custom-input" placeholder="Masukan Email Anda" name="email" required>
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" class="custom-input" placeholder="Masukan Password" name="password" required>
                    </div>

                    <div class="form-options">
                        <input type="checkbox" id="rem">
                        <label for="rem">Remember me</label>
                    </div>

                    <button type="submit" name="login" class="btn-login-submit">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>