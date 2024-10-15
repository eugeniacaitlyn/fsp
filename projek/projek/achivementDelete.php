<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Achievement</title>
</head>
<body>
<?php
        $koneksi = new mysqli("localhost", "root", "", "capstone");

        if ($koneksi->connect_errno) {
            echo "Koneksi Failed: " .$koneksi->connect_error;
        }
       
        $idachievement = $_GET['id'];

        $sql = "DELETE FROM achievement WHERE idachievement =?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $idachievement);
        $stmt->execute();
        $koneksi->close();
        header("Location: achivement.php");
    ?>
    
</body>
</html>