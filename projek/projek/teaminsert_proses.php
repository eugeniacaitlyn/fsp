<?php
    $koneksi = new mysqli("localhost","root","","capstone");
        
    if(isset($_POST['submit'])){
        $idgame = $_POST["idgame"];
        $teamname = $_POST["teamname"];

        $sql = "INSERT INTO team(idgame, name) VALUES (?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('is', $idgame, $teamname);
        //ssdsis itu variable, s = string, d = double, i = integer, b=boolean
        $stmt->execute();
    }

    if($stmt){
        echo "Insert Sukses. ";
        echo "ID Team: ".$stmt->insert_id;
    }
    else{
        echo "Insert Gagal.";
    }
    $koneksi ->close();
?>
<br>
<a href="teamselect.php">Back to All Teams</a>