<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');
        $koneksi = new mysqli("localhost", "root", "", "capstone");
        // Fetch team details
        $idteam = $_GET['id'];
        $stmt = $koneksi->prepare("SELECT * FROM team WHERE idteam=?");
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $idgame = $row['idgame'];
            $teamname = $row['name'];
        } else {
            die("Invalid ID Team");
        }

        $sql = "SELECT idgame, name FROM game";
        $result = $koneksi->query($sql);
        $games = $result->fetch_all(MYSQLI_ASSOC);

        $koneksi->close();
    ?>
    <div class="main">
        <form method="POST" action="teamedit_proses.php">
            <label>Game</label>
            <select name="idgame">
                <?php foreach ($games as $game): ?>
                    <option value="<?= $game['idgame'] ?>" <?= ($game['idgame'] == $idgame) ? 'selected' : '' ?>>
                        <?= $game['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            
            <label>Team Name</label>
            <input type="text" name="teamname" value="<?= htmlspecialchars($teamname) ?>"><br>  
            <input type="hidden" name="idteam" value="<?= htmlspecialchars($idteam) ?>">
            <input type="submit" name="submit" value="Edit Team" class="pagination-btn"><br>
        </form>
    </div>
</body