<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Event</title>
</head>
<body>
<?php
        $koneksi = new mysqli("localhost", "root", "", "capstone");

        if ($koneksi->connect_errno) {
            echo "Koneksi Failed: " .$koneksi->connect_error;
        }
       
        $idevent = $_GET['id'];

        $sql = "DELETE FROM event WHERE idevent =?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        $koneksi->close();
        header("Location: event.php");
    ?>
    
</body>
</html>