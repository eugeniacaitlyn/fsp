<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Team</title>
    
</head>
<body>
    <div class="team-insert">
        <form method="POST" enctype="multipart/form-data" action="teaminsert_proses.php">
            <label>Game: </label>
            <?php
                $koneksi = new mysqli("localhost", "root", "", "capstone");
                $sql = "SELECT idgame, name FROM game";
                $result = $koneksi->query($sql);

                $options = '';
                while ($row = $result->fetch_assoc()) {
                    $options .= "<option value='".$row['idgame']."'>".$row['name']."</option>";
                }

                $koneksi->close();
            ?>

            <select name = "idgame">
                <?php echo $options; ?>
            </select><br><br>
            <label>Team Name: </label>
            <input type="text" name="teamname"></input><br><br>
            <input type="submit" name="submit" value="Add Team"><br><br>
        </form>
        <br>
        <a href="adminhome.php">Back to Home</a>
    </div>
</body>
</html>