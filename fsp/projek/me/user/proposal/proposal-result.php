<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/user/proposal/cProposal.php');

if (!isset($_SESSION['username'])) {
    header('location:../login.php');
    exit();
}

$username = $_SESSION['username'];
$db = new Database();
$dbConnection = $db->getConnection();
$proposal = new Proposal($dbConnection);

$user = $proposal->getUserDetails($username);
$fullName = $user['name'] ?? "Unknown User";
$idmember = $user['idmember'] ?? 0;

$keyword = $_GET['keyword'] ?? "";
$proposalResult = $proposal->searchProposals($idmember, $keyword);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Proposal Result</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <div class="main">
        <main class="table">
            <div class="table__header">
                <h1>Proposals for <?= htmlspecialchars($fullName) ?></h1>
                <form method="get" action="">
                    <div class="search-container">
                        <div class="input-box">
                            <input type="text" name="keyword" placeholder="Search data">
                            <i class="bx bx-search"></i>
                        </div>
                        <button type="submit" name="submit" value="Search">Search</button>
                        <div class="isi register-link">
                            <button type="button" class="add-new-button" onclick="window.location.href='../home.php'">Back</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th>Team</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($proposalResult->num_rows > 0): ?>
                            <?php while ($row = $proposalResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['Team']) ?></td>
                                    <td><?= htmlspecialchars($row['Description']) ?></td>
                                    <td><?= htmlspecialchars($row['Status']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3">No proposals found for <?= htmlspecialchars($fullName) ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
