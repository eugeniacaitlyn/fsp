<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game</title>
</head>
<body>
    <?php
        $koneksi = new mysqli("localhost", "root", "", "capstone");

        $sql = "select * from game where idgame=?";
        $stmt = $koneksi->prepare($sql); //kalo error di sini sql bermasalah
        $idgame = $_GET['id'];
        $stmt->bind_param("i", $idgame);
        
        $stmt->execute();
        $result = $stmt->get_result();


        if ($row = $result->fetch_assoc()) {
            $gamename = $row['name'];
            $gamedesc = $row['description'];
        }
        else {
            die("Invalid Game ID");
        }
        $koneksi->close();
    ?>

    <form method="POST" action="gameedit_proses.php">
        <label>Game Name</label>
        <input type="text" name="gamename" value="<?=$gamename?>"> <br>
        
        <label>Game Description</label>
        <textarea name="gamedesc" value="<?=$gamedesc?>"><?= htmlspecialchars($gamedesc) ?></textarea><br>
        
        <input type="hidden" name="idgame" value="<?=$idgame?>">
        <input type="submit" name="submit" value="Edit Game"><br><br>
    </form>
</body>
</html>