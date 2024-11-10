<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Achievement</title>
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

        $idachievement = $_GET['id'] ?? null;

        if ($idachievement) {
            $achievementData = $achievement->getAchievementById($idachievement);
            if (!$achievementData) {
                die("Invalid achievement ID.");
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idachievement = $_POST["idachievement"];
                $team = $_POST['team'];
                $name = $_POST["name"];
                $date = $_POST["date"];
                $description = $_POST["description"];

                if ($achievement->updateAchievement($idachievement, $team, $name, $date, $description)) {
                    header("Location: /fsp/projek/me/admin/achievement/achievement.php");
                    exit();
                } else {
                    echo "<p>Edit failed.</p>";
                }
            }

            $teams = $achievement->getTeams();
        } else {
            die("No ID provided for the achievement.");
        }

        $dbConnection->close();
    ?>

    <div class="main">
        <form action="" method="POST">
            <label for="team">Team:</label>
            <select name="team" id="team">
                <?php
                foreach ($teams as $teamRow) {
                    $selected = ($achievementData['team'] == $teamRow['name']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($teamRow['name']) . "' $selected>" . htmlspecialchars($teamRow['name']) . "</option>";
                }
                ?>
            </select>
            <br>

            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($achievementData['name']) ?>"> <br>

            <label for="date">Achievement Date:</label>
            <input type="date" name="date" value="<?= htmlspecialchars($achievementData['date']) ?>"> <br>

            <label>Description</label>
            <textarea name="description" rows="5" cols="50"><?= htmlspecialchars($achievementData['description']) ?></textarea><br>

            <input type="hidden" name="idachievement" value="<?= htmlspecialchars($achievementData['idachievement']) ?>">
            <br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>