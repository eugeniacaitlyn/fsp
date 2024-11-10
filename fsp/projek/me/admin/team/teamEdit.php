<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>

<body>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/aside.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/team/cTeam.php');

    $db = new Database();
    $dbConnection = $db->getConnection();
    $teamClass = new Team($dbConnection);

    if (isset($_GET['id'])) {
        $idteam = $_GET['id'];
        $teamData = $teamClass->getTeamById($idteam);

        if (!$teamData || !isset($teamData['idgame'])) {
            die("Invalid Team ID or missing game data.");
        }

        $idgame = $teamData['idgame'];
        $teamname = $teamData['Team'];
    } else {
        die("Team ID is missing.");
    }

    $games = $teamClass->getGames();

    if (isset($_POST['submit'])) {
        $idgame = $_POST['idgame'];
        $teamname = $_POST['teamname'];
        $idteam = $_POST['idteam'];

        if ($teamClass->updateTeam($idteam, $idgame, $teamname)) {
            echo "<script>
                    alert('Team updated successfully!');
                    window.location.href = '/fsp/projek/me/admin/team/team.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to update team!');
                  </script>";
        }
    }
    ?>

    <div class="main">
        <form method="POST" action="">
            <label>Game: </label>
            <select name="idgame">
                <?php foreach ($games as $game): ?>
                    <option value="<?= $game['idgame'] ?>" <?= ($game['idgame'] == $idgame) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($game['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label>Team Name: </label>
            <input type="text" name="teamname" value="<?= htmlspecialchars($teamname) ?>" required><br><br>

            <input type="hidden" name="idteam" value="<?= htmlspecialchars($idteam) ?>">
            <input type="submit" name="submit" value="Edit Team" class="pagination-btn"><br><br>
        </form>
    </div>
</body>

</html>