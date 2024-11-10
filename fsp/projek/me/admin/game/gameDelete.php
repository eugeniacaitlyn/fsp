<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/game/cGame.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');

    $db = new Database();
    $dbConnection = $db->getConnection();
    $game = new Game($dbConnection);

    if (isset($_GET['id'])) {
        $idgame = $_GET['id'];

        $deleted = $game->deleteGame($idgame);

        if ($deleted) {
            echo "Game deleted successfully.";
        } else {
            echo "Failed to delete the game.";
        }
    } else {
        echo "No game ID provided.";
    }

    header("Location: /fsp/projek/me/admin/game/game.php");
    exit();
?>
