<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit achievement</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">

    
</head>
<body>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');

        $koneksi = new mysqli("localhost", "root", "", "capstone");

        if ($koneksi->connect_errno) {
            echo "Koneksi Failed: " .$koneksi->connect_error;
        }
       
        $idachievement = $_GET['id'];

        $sql = "SELECT ac.*, t.name as team FROM achievement ac inner join team t on ac.idteam = t.idteam where idachievement = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $idachievement);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $idachievement  = $row['idachievement'];
            $name = $row['name'];
            $team = $row['team'];
            $date = $row['date'];
            $description = $row['description'];
        }
        else {
            die("Invalid ID Movie");
        }

        $koneksi->close();
    ?>
    
    <div class="main">
        <form action="achivementEditProses.php" method="POST" enctype="multipart/form-data">
            <label for="team">Team :</label>
            <select name="team" id="team" >
                <?php
                $koneksi = new mysqli("localhost", "root", "", "capstone");
                if ($koneksi->connect_errno) {
                    echo "Koneksi Failed: " . $koneksi->connect_error;
                }         
                $sql = "SELECT * FROM team";
                $stmt = $koneksi->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                }
                $koneksi->close();
                $stmt->close();
                
                ?>
            </select>
            <br>
                <label>Name</label>
                <input type="text" name="name" value="<?=$name?>"> <br>
                
                <label for="date">Achievement Date:</label>
                <input type="date" name="date" value="<?=$date?>"> <br>

                <label>Description</label>
                <textarea name="description" rows="5" cols="50"><?=$description?></textarea><br>

                <input type="hidden" name="idachievement" value="<?=$idachievement?>">
            <br>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
    
</body>
</html>