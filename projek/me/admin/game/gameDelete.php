<?php
    $koneksi = new mysqli("localhost","root","","capstone");
    
    if ($koneksi->connect_errno) {
        echo "Koneksi Failed: " .$koneksi->connect_error;
    }

    $idgame = $_GET['id'];
    $sql = "DELETE FROM capstone.game WHERE idgame=?;";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('i', $idgame);
    $stmt->execute();

    header("Location: game.php");
    $koneksi ->close();
?>
<br>