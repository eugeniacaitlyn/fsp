<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/team/cTeam.php');

$db = new Database();
$dbConnection = $db->getConnection();
$teamClass = new Team($dbConnection);

$idteam = $_GET['id'] ?? null;

if (!$idteam) {
    die("Invalid request.");
}

//cek kalo tim udh pernah ada achievement atau join event
$check_sql = "SELECT 
                (SELECT COUNT(*) FROM achievement WHERE idteam = ?) AS achievement_count, 
                (SELECT COUNT(*) FROM event_teams WHERE idteam = ?) AS event_count";
$check_stmt = $dbConnection->prepare($check_sql);
$check_stmt->bind_param("ii", $idteam, $idteam);
$check_stmt->execute();
$check_stmt->bind_result($achievement_count, $event_count);
$check_stmt->fetch();
$check_stmt->close();

if ($achievement_count > 0 || $event_count > 0) {
    echo "<script>
        alert('Cannot delete team because it has achievements or is part of events.');
        window.location.href = '/fsp/projek/me/admin/team/team.php';
    </script>";
} else {
    if ($teamClass->deleteTeam($idteam)) {
        header("Location: /fsp/projek/me/admin/team/team.php");
        exit();
    } else {
        echo "<script>
            alert('Failed to delete the team.');
            window.location.href = '/fsp/projek/me/admin/team/team.php';
        </script>";
    }
}

$dbConnection->close();
?>
