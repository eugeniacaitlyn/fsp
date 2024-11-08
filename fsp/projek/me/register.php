<?php
@include 'database.php';
session_start();

require 'cRegister.php';

$error = '';
if (isset($_POST['submit'])) {
    $register = new cRegister($conn);
    $register->register($_POST['fname'], $_POST['lname'], $_POST['username'], $_POST['password'], $_POST['cpassword']);
    $error = $register->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/loginregist.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
</head>
<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Register</h1>

            <div class="column">
                <div class="input-box">
                    <input type="text" name="fname" required placeholder="First Name">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="text" name="lname" required placeholder="Last Name">
                    <i class='bx bxs-user'></i>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <input type="text" name="username" required placeholder="Username">
                    <i class='bx bxs-user'></i>
                </div>
            </div>  

            <div class="column">
                <div class="input-box">
                    <input type="password" name="password" required placeholder="Password">
                    <i class='bx bxs-lock'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="cpassword" required placeholder="Confirmation">
                    <i class='bx bxs-lock'></i>
                </div>
            </div>

            <div class="button">
                <button type="submit" name="submit" value="Register Now" class="btn-submit">Register</button>
                <button type="button" class="btn-back" onclick="window.location.href='main.php'">Back</button>
            </div> 
            
            <div class="register-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
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
