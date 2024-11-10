<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Achievement</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/aside.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/achievement/cAchievement.php');

    $db = new Database();
    $dbConnection = $db->getConnection();
    $achievement = new Achievement($dbConnection);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $team = $_POST['team'];
        $name = $_POST["name"];
        $date = $_POST["date"];
        $description = $_POST["description"];

        if ($achievement->createAchievement($team, $name, $date, $description)) {
            header("Location: achievement.php");
            exit;
        } else {
            echo "<p>Failed to add achievement.</p>";
        }
    }

    $teams = $achievement->getTeams();
    $dbConnection->close();
?>

<div class="main">
    <form action="" method="POST">
        <label for="team">Team:</label>
        <select name="team" id="team">
            <?php
            foreach ($teams as $team) {
                echo "<option value='" . htmlspecialchars($team['name']) . "'>" . htmlspecialchars($team['name']) . "</option>";
            }
            ?>
        </select>
        <br>

        <label for="name">Achievement Name:</label>
        <input type="text" name="name" required> <br>

        <label for="date">Achievement Date:</label>
        <input type="date" name="date" required> <br>

        <label for="description">Description:</label>
        <textarea name="description" rows="5" cols="50" required></textarea><br>

        <br>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>
</body>
</html>
