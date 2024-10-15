<?php
    $koneksi = new mysqli("localhost","root","","capstone");
        
    if(isset($_POST['submit'])){
        $idmember = $_POST["idmember"];
        $idteam = $_POST["idteam"];
        $idjoin_proposal =$_POST["idjoin_proposal"];

        $koneksi->begin_transaction();
        try{
            $sql = "INSERT INTO team_members(idteam, idmember) VALUES (?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param('ii', $idteam, $idmember);
            //ssdsis itu variable, s = string, d = double, i = integer, b=boolean
            $stmt->execute();
    
            $sql2 = "UPDATE join_proposal SET status = 'approved' WHERE idjoin_proposal = ?";
            $stmt2 = $koneksi->prepare($sql2);
            $stmt2->bind_param('i', $idjoin_proposal);
            $stmt2->execute();

            $koneksi->commit();
            echo "Insert Member and Update Proposal Succeeded";
        } catch (Exception $e) {
            $koneksi->rollback();
            echo "Transaction failed: " . $e->getMessage();
        }
        $stmt->close();
        $stmt2->close();
    }
    $koneksi ->close();
?>
<br>
<a href="teamselect.php">Back to All Teams</a>