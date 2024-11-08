<?php
    $koneksi = new mysqli("localhost", "root", "", "capstone");

    if(isset($_POST['submit'])){
        $gamename = $_POST["gamename"];
        $gamedesc = $_POST["gamedesc"];
        $idgame = $_POST["idgame"];

        $sql = "UPDATE game SET name=?, description=? WHERE idgame=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssi", $gamename, $gamedesc, $idgame);
        $stmt->execute();

        if ($stmt) {
            echo "Edit Game Succeeded.";
        }
        else {
            echo "Edit Failed.";
        }
    }
    header("Location: /fsp/projek/me/admin/game/game.php");
    $koneksi ->close();
?>
<br>
