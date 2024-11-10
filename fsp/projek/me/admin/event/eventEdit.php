<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: auto auto;
            gap: 20px;
        }

        .grid-item {
            border: 1px solid #ddd;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #D59966;
        }

        .grid-item table {
            min-height: 200px;
        }
    </style>
</head>

<body>
    <?php
    ob_start();
    include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');
    require_once 'cEvent.php';

    $dbConnection = new mysqli("localhost", "root", "", "capstone");
    if ($dbConnection->connect_errno) {
        die("Database connection failed: " . $dbConnection->connect_error);
    }
    $event = new Event($dbConnection);

    $idevent = $_GET['id'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['edit_event'])) {
            $name = $_POST["name"];
            $date = $_POST["date"];
            $description = $_POST["description"];
            if ($event->updateEvent($idevent, $name, $date, $description)) {
                header("Location: event.php");
                exit;
            } else {
                echo "Edit Failed.";
            }
        } elseif (isset($_POST['add_team'])) {
            $idteam = $_POST['idteam'];
            $event->addTeamToEvent($idevent, $idteam);
        } elseif (isset($_POST['delete_team'])) {
            $idteam = $_POST['idteam'];
            $event->deleteTeamFromEvent($idevent, $idteam);
        }
    }

    $eventData = $event->getEventById($idevent);
    if (!$eventData) {
        die("Invalid Event ID");
    }

    $teamsInEvent = $event->getTeamsInEvent($idevent);
    $allTeams = $event->getAllTeams();
    ob_end_flush();
    ?>

    <div class="main">
        <form method="POST">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($eventData['name']) ?>"> <br>

            <label for="date">Event Date:</label>
            <input type="date" name="date" value="<?= htmlspecialchars($eventData['date']) ?>"> <br>

            <label>Description</label>
            <textarea name="description" rows="5"
                cols="50"><?= htmlspecialchars($eventData['description']) ?></textarea><br>

            <input type="hidden" name="idevent" value="<?= $idevent ?>">
            <input type="submit" name="edit_event" value="Edit"><br><br>
        </form>
    </div>

    <div class="grid-container">
        <div class="grid-item">
            <h3>Teams in Event</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($teamsInEvent as $team): ?>
                    <tr>
                        <td><?= htmlspecialchars($team['name']) ?></td>
                        <td>
                            <!-- Each team has its own form for deletion -->
                            <form method="POST" onsubmit="return confirm('Are you sure you want to remove this team?');">
                                <input type="hidden" name="idteam" value="<?= $team['idteam'] ?>">
                                <input type="hidden" name="delete_team" value="1">
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($teamsInEvent)): ?>
                    <tr>
                        <td colspan="2">No teams in event</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="grid-item">
            <h3>All Teams</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($allTeams as $team): ?>
                    <tr>
                        <td><?= htmlspecialchars($team['name']) ?></td>
                        <td>
                            <!-- Each team has its own form for addition -->
                            <form method="POST" onsubmit="return confirm('Are you sure you want to add this team?');">
                                <input type="hidden" name="idteam" value="<?= $team['idteam'] ?>">
                                <input type="hidden" name="add_team" value="1">
                                <button type="submit">Add</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($allTeams)): ?>
                    <tr>
                        <td colspan="2">No teams available</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

</body>

</html>