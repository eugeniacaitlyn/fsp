<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Team</title>
    
</head>
<body>
<?php
        $koneksi = new mysqli("localhost", "root", "", "capstone");

        if ($koneksi->connect_errno) {
            echo "Koneksi Failed: " .$koneksi->connect_error;
        }
        else {
            echo "Koneksi Success.";
        }

        $idteam = $_GET['id'];

        $sql = "SELECT * FROM team WHERE idteam=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $name = $row['name'];
        }
        else {
            die("Invalid ID Team");
        }

        $koneksi->close();
    ?>
    <form method="POST" action="teamdelete_proses.php">
        <label>Do you realy want to delete these?</label>
        <button type="submit" name="yes" value="delete"><br><br>
        <button type="submit" name="no" value="cancle" <a href="teamselect.php">back to index</a>><br><br>

        <input type="text" name="judul" value="<?=$idteam?>"> <br>
        
        <label>game</label>
        <input type="date" name="rilis" value="<?=$idgame?>"><br>
        <!-- <input type="hidden" name="idmovie" value="<?=$idmovie?>"> -->
        <input type="submit" name="submit" value="delete"><br><br>
    </form>
</body>
</html>