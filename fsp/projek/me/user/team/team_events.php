<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/user/team/cTeam.php');

$teamId = $_GET['team_id'] ?? null;
$db = new Database();
$teamClass = new cTeam($db);
$teamEvents = $teamId ? $teamClass->getTeamEvents($teamId) : [];
$teamName = $teamId ? $teamClass->getTeamName($teamId) : 'Your Team';

$keyword = $_GET['keyword'] ?? '';
$filteredEvents = array_filter($teamEvents, function($event) use ($keyword) {
    return stripos($event['event_name'], $keyword) !== false;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $teamName; ?> - Events</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <div class="main">
        <main class="table">
            <div class="table__header">
                <h1>Events of <?php echo $teamName; ?></h1>
                <form method="get" action="">
                    <div class="search-container">
                        <div class="input-box">
                            <input type="text" name="keyword" placeholder="Search data" value="<?php echo htmlspecialchars($keyword); ?>">
                            <i class="bx bx-search"></i>
                        </div>
                        <button type="submit" name="submit" value="Search">Search</button>
                        <div class="isi register-link">
                            <button type="button" class="add-new-button" onclick="window.location.href='team.php'">Back</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filteredEvents as $index => $event): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                                <td><?php echo $event['event_date']; ?></td>
                                <td><?php echo htmlspecialchars($event['event_description']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
