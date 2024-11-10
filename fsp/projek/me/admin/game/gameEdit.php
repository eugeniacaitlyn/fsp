<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/aside.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/game/cGame.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');

    $db = new Database();
    $dbConnection = $db->getConnection();
    $game = new Game($dbConnection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $gamename = $_POST['gamename'];
        $gamedesc = $_POST['gamedesc'];
        $idgame = $_POST['idgame'];

        $updated = $game->updateGame($idgame, $gamename, $gamedesc);

        if ($updated) {
            echo "Game updated successfully.";
        } else {
            echo "Failed to update the game.";
        }

        header("Location: /fsp/projek/me/admin/game/game.php");
        exit;
    }

    if (isset($_GET['id'])) {
        $idgame = $_GET['id'];

        $gameData = $game->getGameById($idgame);

        if (!$gameData) {
            die("Invalid Game ID.");
        }

        $gamename = $gameData['name'];
        $gamedesc = $gameData['description'];
    } else {
        die("Game ID is missing.");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>

    <div class="main">
        <form method="POST" action="">
            <label>Game Name:</label>
            <input type="text" name="gamename" value="<?= htmlspecialchars($gamename) ?>"><br>

            <label>Game Description:</label>
            <textarea name="gamedesc" rows="5" cols="25"><?= htmlspecialchars($gamedesc) ?></textarea><br>

            <input type="hidden" name="idgame" value="<?= htmlspecialchars($idgame) ?>">
            <input type="submit" name="submit" value="Update Game"><br><br>
        </form>
    </div>
</body>
</html>
