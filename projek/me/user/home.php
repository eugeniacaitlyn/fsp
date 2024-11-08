<?php
    session_start();
    @include '../database.php';

    if(!isset($_SESSION['username'])){
        header('location:../login.php');
        exit();
    }

    $username = $_SESSION['username'];
    


    $query = "SELECT CONCAT(fname, ' ', lname) AS name,idmember FROM member WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
   
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $fullName = $row['name'];
        $idmember = $row['idmember'];
    } else {
        $fullName = "Unknown User";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <link rel="stylesheet" href="../css/loginregist.css">
    <style>
        html, body{
            height: 100vh;
            width: 100%;
            margin:0;
            display: flex;
        }
        body{
            background: url(../images/backgroundStatis2.png) ;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat; 
            margin: 0; 
            padding: 0;
            overflow-x: hidden;
            color:white;
            display: flex;
            height: 100vh; 
        }
        .main{
            flex:1;
            display:flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color:white;
            margin: 48px;
            text-align: center;
        }
        .welcome{
            font-size: 64px;
            line-height: 1;
            font-weight:bold;
        }
        .isi{
            font-size:24px !important;
            margin-top: 36px; 
            line-height: 1;
        }
        .isi a{
            background: #D59966;
            border-radius: 8px;
            border: none;
            padding: 0.5rem;
            outline: none;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="main">
        <form action="" method="post">
            <div class="welcome">
                <p>Welcome, <?php echo $fullName; ?>!</p>
            </div>
            <div class="isi register-link">
                <p>Want to join a Team? <a href="proposal.php?idmember=<?php echo $idmember; ?>">Click here!</a></p>
            </div>

            <div class="isi register-link">
                <p>Check Your Team Proposals <a href="proposal-result.php?idmember=<?php echo $idmember; ?>">Click here!</a></p>
            </div>

            <div class="isi register-link">
                <p>Want to Log Out? <a href="../main.php">Log out</a></p>
            </div>
        </form>
    </div>
</body>
</html>