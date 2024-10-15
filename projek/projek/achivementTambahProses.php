<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
        $koneksi = new mysqli("localhost", "root", "", "capstone");

        if ($koneksi->connect_errno) {
            echo "Koneksi Failed: " .$koneksi->connect_error;
        }
       
        $idachievement = $_GET['id'];

        $sql = " select t.idteam as idTeam,t.name as team, ev.name as event from team t 
                right join  event_teams evt on t.idteam=evt.idteam 
                left join event ev on evt.idevent=ev.idevent WHERE evt.idteam=? ";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $idachievement);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $idteam = $row['idTeam'];
            $team= $row['team'];
            $event = $row['event'];
        }
        else {
            die("Invalid ID Movie");
        }

        $koneksi->close();
    ?>
    <form method="POST" action="achivementTambahProses2.php">
        <label>Team</label>
        <input type="text" name="idteam" value="<?=$team?>" readonly> <br>

        <label>Event</label>
        <input type="text" name="event" value="<?=$event?>" > <br>

        <label for="date">Event Date:</label>
        <input type="date" name="date" > <br>

        <label>Description</label>
        <textarea name="description" rows="5" cols="50"></textarea><br>

        <input type="hidden" name="idteam" value="<?=$idteam?>">
        <input type="submit" name="submit" value="Add"><br><br>
    </form>
</body>
</html>

