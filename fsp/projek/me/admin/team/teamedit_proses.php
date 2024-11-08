<?php
    $koneksi = new mysqli("localhost", "root", "", "capstone");

    if(isset($_POST['submit'])){
        $idgame = $_POST["idgame"];
        $name = $_POST["teamname"];
        $idteam = $_POST["idteam"];

        $sql = "UPDATE team SET idgame=?, name=? WHERE idteam=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("isi", $idgame, $name, $idteam);
        $stmt->execute();

        if ($stmt) {
            echo "Edit Team Succeeded.";
        }
        else {
            echo "Edit Failed.";
        }
    }
    header("Location: /fsp/projek/me/admin/team/team.php");

    $koneksi ->close();
?>
<br>
