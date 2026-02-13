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
        exit;
    } else {
        $error = "Login gagal!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BuildBase</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
