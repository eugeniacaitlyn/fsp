<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Team</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <?php
    include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/database.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/team/cTeam.php');

    $db = new Database();
    $dbConnection = $db->getConnection();
    $teamClass = new Team($dbConnection);
    
    if (isset($_POST['submit'])) {
        $idgame = $_POST['idgame'];
        $teamname = $_POST['teamname'];

        if ($teamClass->createTeam($idgame, $teamname)) {  //alertnya belum pake css
            echo "<script>
                    alert('Team added successfully!');
                    window.location.href = '/fsp/projek/me/admin/team/team.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to add the team!');
                  </script>";
        }
    }

    $sql = "SELECT idgame, name FROM game";
    $result = $dbConnection->query($sql);
    $options = '';
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['idgame'] . "'>" . $row['name'] . "</option>";
    }
    ?>
    
    <div class="main">
        <div class="team-insert">
            <form method="POST" action="">
                <label>Game: </label>
                <select name="idgame">
                    <?php echo $options; ?>
                </select><br><br>

                <label>Team Name: </label>
                <input type="text" name="teamname" required><br><br>

                <input type="submit" name="submit" value="Add Team"><br><br>
            </form>
        </div>
    </div>

</body>
</html>
