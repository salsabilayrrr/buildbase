<?php
session_start();
include "koneksi.php";

if(isset($_POST['login'])){
    $role = $_POST['role'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, 
        "SELECT * FROM users 
         WHERE email='$email' 
         AND role='$role'"
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

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 350px;">
        <h4 class="text-center mb-3">Login BuildBase</h4>

        <?php if(isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
        <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select rounded-3" required>
                    <option value="">Select Role</option>
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
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100">
                Login
            </button>
        </form>
    </div>
</div>

</body>
</html>
