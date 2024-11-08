<?php
    $koneksi = new mysqli("localhost","root","","capstone");
    if ($koneksi ->connect_errno){
        echo "Koneksi Failed : ".$koneksi->connect_error;
    }
    
    if(isset($_POST['submit'])){
        $idachievement = $_POST["idachievement"];
        $team = $_POST['team'];
        $name = $_POST["name"];
        $date = $_POST["date"];
        $description = $_POST["description"];

        $sql = "UPDATE achievement SET idteam=(select idteam from team where name = ?), name=?, date=? ,description=? WHERE idachievement=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssssi", $team,$name,$date, $description, $idachievement);
        $stmt->execute();

        if ($stmt) {
            header("Location: achievement.php");
            echo "Edit Success.";
        }
        else {
            echo "Edit Failed.";
            
        }
    }
    $koneksi ->close();
    
?>
