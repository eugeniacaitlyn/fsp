<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/aside.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/game/cGame.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');

    $db = new Database();
    $dbConnection = $db->getConnection();
    $game = new Game($dbConnection);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $gamename = $_POST["gamename"];
        $gamedesc = $_POST["gamedesc"];

        $gameAdded = $game->createGame($gamename, $gamedesc);

        if ($gameAdded) {
            echo "Insert Game Succeeded";
            header("Location: /fsp/projek/me/admin/game/game.php");
            exit();
        } else {
            echo "Insert Failed";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Add</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <div class="main">
        <div class="game-insert">
            <h1>Add New Game</h1>
            <form method="POST" enctype="multipart/form-data">
                <label>Game Name:</label><br>
                <input type="text" name="gamename" required><br><br>

                <label>Description:</label><br>
                <textarea name="gamedesc" required></textarea><br><br>

                <input type="submit" name="submit" value="Add Game"><br><br>
            </form>
        </div>
    </div>
</body>
</html>
