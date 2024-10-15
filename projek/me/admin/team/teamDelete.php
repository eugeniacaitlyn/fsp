<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Team</title>
    
</head>
<body>
<?php
        $koneksi = new mysqli("localhost", "root", "", "capstone");

        if ($koneksi->connect_errno) {
            echo "Koneksi Failed: " .$koneksi->connect_error;
        }
        else {
            echo "Koneksi Success.";
        }

        $idteam = $_GET['id'];

        $sql = "SELECT * FROM team WHERE idteam=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $name = $row['name'];
        }
        else {
            die("Invalid ID Team");
        }

        $koneksi->close();
</body>
</html>