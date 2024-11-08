<?php
    session_start();
    @include '../database.php';

    if(!isset($_SESSION['username'])){
        header('location:../login.php');
        exit();
    }

    $username = $_SESSION['username'];
   


    $sql = "SELECT CONCAT(fname, ' ', lname) AS name,idmember FROM member WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username );
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) 
        {
            $fullName = $row['name'];
            $idmember = $row['idmember'];
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php')
        // include('aside.php');
    ?>
    <div class="main">
        <div class="welcome">
            <p>WELCOME</p>
        </div>
        <div class="nama">
            <p><?php echo $fullName; ?></p>
        </div>
    </div>
</body>
</html>