<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
        $koneksi = new mysqli("localhost", "root", "", "capstone");

        if ($koneksi->connect_errno) {
            echo "Koneksi Failed: " .$koneksi->connect_error;
        }

        if(isset($_POST['submit'])){
            $idteam = $_POST["idteam"];
            $name = $_POST["event"];
            $date = $_POST["date"];
            $description = $_POST["description"];
    
            $sql = "INSERT INTO achievement (idteam, name, date, description) VALUES (?, ?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("isss",$idteam, $name,$date,$description);
            $stmt->execute();
    
            if ($stmt) {
                header("Location: achivement.php");
                echo "Add Success.";
            }
            else {
                echo "Add Failed.";
                
            }
        }
    ?>
</body>
</html>