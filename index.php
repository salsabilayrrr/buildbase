<?php
    session_start();
    include "koneksi.php";

    if(isset($_POST['login'])){
        $role = $_POST['role'];
        $email = $_POST['email'];
        $password = $_POST['password'];

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
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BuildBase</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/styleLogin.css">
</head>

<body class="bg-light">

<div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 py-5">
    
    <div class="text-center mb-4">
        <img src="assets/img/logo.jpg" alt="BuildBase Logo" class="logo-img">
        <h4 class="logo-title mt-2">BuildBase</h4>
    </div>

    <div class="card login-card" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-3" style="font-weight: 600;">LOGIN</h2>

        <?php if(isset($error)) { ?>
            <div class="alert alert-danger py-2" style="font-size: 0.8rem;"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label role-label"><b>Role</b></label>
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="cs">Customer Service</option>
                    <option value="estimator">Estimator</option>
                    <option value="drafter">Drafter</option>
                    <option value="engineer">Engineer</option>
                    <option value="finance">Finance</option>
                    <option value="manager">Manager</option>
                    <option value="qc">Quality Control</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label"><b>Email</b></label>
                <input type="email" name="email" class="form-control" placeholder="Masukan Email Anda" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><b>Password</b></label>
                <input type="password" name="password" class="form-control" placeholder="Masukan Password" required>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="remember">
                <label class="form-check-label fw-bold" for="remember" style="font-size: 0.85rem;">
                    Remember me
                </label>
            </div>

            <button type="submit" name="login" class="btn btn-primary btn-login">
                LOGIN
            </button>
        </form>
    </div>
</div>

</body>
</html>
