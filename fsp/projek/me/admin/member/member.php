<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Members</title>
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

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $idteam = $_GET['id'];

        $teamData = $teamClass->getTeamById($idteam);
        if ($teamData) {
            $teamname = $teamData['name'];
        } else {
            die("Invalid Team ID or data not found.");
        }

        $teamMembers = $teamClass->getTeamMembers($idteam);
    } else {
        die("Team ID is missing.");
    }
    ?>

    <div class="main">
        <main class="table">
            <div class="table__header">
                <h1>Team <?= htmlspecialchars($teamname) ?></h1>
                <a href="/fsp/projek/me/admin/team/team.php">
                    <button class="add-new-button">Back
                        <i class="bx bx-arrow-back"></i>
                    </button>
                </a>
            </div>
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teamMembers as $member): ?>
                            <tr>
                                <td><?= $member['idmember'] ?></td>
                                <td><?= htmlspecialchars($member['fullname']) ?></td>
                                <td><?= htmlspecialchars($member['username']) ?></td>
                                <td>
                                    <a class="pagination-btn" href="/fsp/projek/me/admin/member/memberDelete.php?id=<?= $member['idmember'] ?>" onclick="return confirm('Are you sure you want to delete this member?')">
                                        <button class="icon-button trash">
                                            <i class="bx bxs-trash-alt"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php
    $dbConnection->close();
    ?>
</body>
</html>
