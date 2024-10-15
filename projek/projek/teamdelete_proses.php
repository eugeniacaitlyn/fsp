<?php
    $koneksi = new mysqli("localhost","root","","capstone");
    
    if ($koneksi->connect_errno) {
        echo "Koneksi Failed: " .$koneksi->connect_error;
    }

    $idteam = $_GET['id'];
    $sql = "DELETE FROM capstone.team WHERE idteam=?;";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('i', $idteam);
    $stmt->execute();

    header("Location: teamselect.php");
    $koneksi ->close();
?>
<br>
