<?php
    $koneksi = new mysqli("localhost","root","","capstone");
        
    if(isset($_POST['submit'])){
        $gamename = $_POST["gamename"];
        $gamedesc = $_POST["gamedesc"];

        $sql = "INSERT INTO game(name, description) VALUES (?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param('ss', $gamename, $gamedesc);
        //ssdsis itu variable, s = string, d = double, i = integer, b=boolean
        $stmt->execute();
    }

    if($stmt){
        echo "Insert Game Succeeded";
    }
    else{
        echo "Insert Failed";
    }
    $koneksi ->close();
?>
<br>
<a href="gameselect.php">Back to All Games</a>