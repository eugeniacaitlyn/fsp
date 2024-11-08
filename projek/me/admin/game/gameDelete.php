<?php
    $koneksi = new mysqli("localhost","root","","capstone");
    
    if ($koneksi->connect_errno) {
        echo "Koneksi Failed: " .$koneksi->connect_error;
    }

    $idgame = $_GET['id'];
    $sql = "DELETE FROM game WHERE idgame=?;";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('i', $idgame);
    $stmt->execute();

    header("Location: /fsp/projek/me/admin/game/game.php");
    $koneksi ->close();
?>
<br>