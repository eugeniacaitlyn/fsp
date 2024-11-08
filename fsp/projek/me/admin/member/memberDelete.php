<?php
    $koneksi = new mysqli("localhost","root","","capstone");
    
    $idmember = $_GET['id'];
    $sql = "DELETE FROM capstone.team_members WHERE idmember=?;";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param('i', $idmember);
    $stmt->execute();

    if($stmt){
        echo "Delete success. ";
    }
    else{
        echo "Delete Gagal.";
    }
    header("Location: /fsp/projek/me/admin/team/team.php");
    $koneksi ->close();
?>
<br>
