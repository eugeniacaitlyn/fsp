<?php
    @include 'database.php';
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $error = ''; 

    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $pass = md5($_POST['password']);

        $select = "SELECT * FROM member WHERE username = '$username' && password = '$pass' ";
        $result = mysqli_query($conn, $select);

        if(mysqli_num_rows($result) > 0){

            $row = mysqli_fetch_array($result);
            if($row['profile'] == 'admin'){
                $_SESSION['username'] = $row['username'];
                header('location:admin/home.php');
                exit();
            } elseif($row['profile'] == 'member'){
                $_SESSION['username'] = $row['username'];
                //echo "Redirecting to: user/home.php";
                header('location:user/home.php');
                exit(); 
            }
            
        } else {
            $error = 'Username atau Password salah. Silakan coba lagi.';
        }
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
                <input type="username" name="username" required placeholder="Username">
                <i class='bx bxs-user'></i>
            </div>
            <div class="column input-box">
                <input type="password" name="password" required placeholder="Password">
                <i class='bx bxs-lock'></i>
            </div>
            <div class="button">
                <button type="submit" name="submit" value="Login Now" class="btn-submit">Login</button>
                <button type="back" class="btn-back" onclick= "window.location.href='main.php'">Back</button>
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
