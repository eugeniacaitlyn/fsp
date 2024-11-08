<?php
@include 'database.php';
session_start();

require 'cLogin.php';

$error = '';
if (isset($_POST['submit'])) {
    $login = new cLogin($conn);
    $login->login($_POST['username'], $_POST['password']);
    $error = $login->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginregist.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
</head>
<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Login</h1>

            <div class="column input-box">
                <input type="text" name="username" required placeholder="Username">
                <i class='bx bxs-user'></i>
            </div>
            <div class="column input-box">
                <input type="password" name="password" required placeholder="Password">
                <i class='bx bxs-lock'></i>
            </div>
            <div class="button">
                <button type="submit" name="submit" value="Login Now" class="btn-submit">Login</button>
                <button type="button" class="btn-back" onclick="window.location.href='main.php'">Back</button>
            </div> 
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>

    <script>
        <?php if (!empty($error)): ?>
            alert('<?php echo $error; ?>');
        <?php endif; ?>
    </script>
</body>
</html>
