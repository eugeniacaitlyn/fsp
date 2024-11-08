<?php
    $koneksi = new mysqli("localhost","root","","capstone");
        
    if(isset($_POST['submit'])){
        $idmember = $_POST["idmember"];
        $idteam = $_POST["idteam"];
        $idjoin_proposal =$_POST["idjoin_proposal"];
        $description = 'Player';

        $koneksi->begin_transaction();
        try{
            $sql = "UPDATE join_proposal SET status='approved' WHERE idjoin_proposal =?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param('i', $idjoin_proposal);
            $stmt->execute();

            $koneksi->commit();

            $sql = "INSERT INTO team_members (idteam, idmember, description) VALUES (?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param('iis', $idteam,$idmember,$description);
            $stmt->execute();

            $koneksi->commit();
            echo "Insert Member and Update Proposal Succeeded";
        } catch (Exception $e) {
            $koneksi->rollback();
            echo "Transaction failed: " . $e->getMessage();
        }
        $stmt->close();
        
    }
    header("Location: /fsp/projek/me/admin/proposal/proposal.php");
    $koneksi ->close();
?>
<br>
