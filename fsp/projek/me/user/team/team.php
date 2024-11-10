<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/user/team/cTeam.php');

if (!isset($_SESSION['username'])) {
    header('location:../login.php');
    exit();
}

$username = $_SESSION['username'];
$db = new Database();
$conn = $db->getConnection();
$teamClass = new cTeam($db);

// Get user details to fetch full name
$query = "SELECT idmember FROM member WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$idmember = $row['idmember'];

$fullName = $teamClass->getUserFullName($idmember);

$teamId = $teamClass->getUserTeamId($idmember);
$teamName = $teamId ? $teamClass->getTeamName($teamId) : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $teamName ? $teamName : 'Your Team'; ?></title>
    <link rel="stylesheet" href="/fsp/projek/me/css/loginregist.css">
    <style>
        html,
        body {
            height: 100vh;
            width: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url(/fsp/projek/me/images/backgroundStatis2.png) center center / cover no-repeat;
            color: white;
            overflow-x: hidden;
        }

        .team-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 48px;
            border-radius: 10px;
        }

        .welcome {
            font-size: 64px;
            font-weight: bold;
            margin-bottom: 36px;
        }

        .link-row {
            display: flex;
            gap: 16px;
            margin-bottom: 36px;
        }

        .link-row a,
        .back-btn a,
        .join-team-btn a {
            background: #D59966;
            color: white;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s ease;
            flex: 1;
            text-align: center;
        }

        .link-row a:hover,
        .back-btn a:hover,
        .join-team-btn a:hover {
            background: #b47a4d;
        }

        .back-btn {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .back-btn a {
            width: calc(3 * 120px + 32px);
            margin: 12px;
        }
    </style>
</head>

<body>
    <div class="team-container">
        <header class="team-header">
            <?php if (!$teamId): ?>
                <div class="welcome">
                    <p>You're not a part of any team, <?php echo htmlspecialchars($fullName); ?></p>
                </div>
                <div class="back-btn">
                    <a href="../proposal/proposal.php?idmember=<?php echo $idmember; ?>" class="btn">Join a Team</a><br><br>
                </div>
            <?php else: ?>
                <div class="welcome">
                    <h1><?php echo $teamName; ?></h1>
                </div>
                <div class="link-row">
                    <a href="team_members.php?team_id=<?php echo $teamId; ?>" class="btn">Members</a>
                    <a href="team_achievements.php?team_id=<?php echo $teamId; ?>" class="btn">Achievements</a>
                    <a href="team_events.php?team_id=<?php echo $teamId; ?>" class="btn">Events</a>
                </div>
            <?php endif; ?>
            <div class="back-btn">
                <a href="../home.php">Back to Home</a>
            </div>
        </header>
    </div>
</body>

</html>
