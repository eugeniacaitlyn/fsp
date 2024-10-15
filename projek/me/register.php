<?php
    @include 'database.php';
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $error = '';  // Variabel untuk menyimpan pesan error

    if(isset($_POST['submit'])){
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $pass = md5($_POST['password']);
        $cpass = md5($_POST['cpassword']);
        $profile = "member";

        // Cek apakah username sudah ada di database
        $select = "SELECT * FROM member WHERE username = '$username'";
        $result = mysqli_query($conn, $select);

        if(mysqli_num_rows($result) > 0){
            // Jika username sudah terdaftar, tampilkan pesan error
            $error = 'User Already Exist!';
        } else {
            // Jika password tidak sama
            if($pass != $cpass){
                $error = 'Password Not Matched!';
            } else {
                // Jika tidak ada masalah, simpan data ke database
                $insert = "INSERT INTO member (fname, lname, username, password, profile) 
                           VALUES ('$fname', '$lname', '$username', '$pass', '$profile')";
                mysqli_query($conn, $insert);

                $_SESSION['success'] = 'Account created successfully! Please login.';
                header('location:login.php');
                exit();
            }
        }
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
                    <input type="username" name="username" required placeholder="Username">
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
                <button type="back" class="btn-back" onclick="window.location.href='main.php'">Back</button>
            </div> 
            
            <div class="register-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>

    <script>
        // Jika ada pesan error dari PHP, tampilkan alert
        <?php if (!empty($error)): ?>
            alert('<?php echo $error; ?>');
        <?php endif; ?>
    </script>
</body>
</html>
