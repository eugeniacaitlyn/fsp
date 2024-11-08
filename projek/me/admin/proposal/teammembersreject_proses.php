<?php
    $koneksi = new mysqli("localhost","root","","capstone");
        
    if(isset($_POST['submit'])){
        $idmember = $_POST["idmember"];
        $idteam = $_POST["idteam"];
        $idjoin_proposal =$_POST["idjoin_proposal"];

        $sql2 = "UPDATE join_proposal SET status = 'rejected' WHERE idjoin_proposal = ?";
        $stmt2 = $koneksi->prepare($sql2);
        $stmt2->bind_param('i', $idjoin_proposal);
        $stmt2->execute();
        echo "Reject Proposal Succeeded";
        $stmt2->close();
        }
        header("Location: /fsp/projek/me/admin/proposal/proposal.php");
    $koneksi ->close();
?>
<br>
