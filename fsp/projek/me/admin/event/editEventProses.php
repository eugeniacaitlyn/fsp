<?php
    $koneksi = new mysqli("localhost","root","","capstone");
    if ($koneksi ->connect_errno){
        echo "Koneksi Failed : ".$koneksi->connect_error;
    }
    
    if(isset($_POST['submit'])){
        $idevent = $_POST["idevent"];
        $name = $_POST["name"];
        $date = $_POST["date"];
        $description = $_POST["description"];

        $sql = "UPDATE event SET name=?, date=? ,description=? WHERE idevent=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sssi", $name,$date, $description, $idevent);
        $stmt->execute();

        if ($stmt) {
            header("Location: event.php");
            echo "Edit Success.";
        }
        else {
            echo "Edit Failed.";
            
        }
    }
    $koneksi ->close();
    
?>
