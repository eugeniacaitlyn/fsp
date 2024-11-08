<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Proposal Result</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <?php
        session_start();
        @include '../database.php';
        
        if (!isset($_SESSION['username'])) {
            header('location:../login.php');
            exit();
        }

        $username = $_SESSION['username'];

        $query = "SELECT CONCAT(fname, ' ', lname) AS name, idmember FROM member WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $fullName = $row['name'];
            $idmember = $row['idmember'];
        } else {
            $fullName = "Unknown User";
            $idmember = 0;
        }

        $keyword = "";
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
        }

        echo '<div class="main">';
        echo '    <main class="table">';
        echo '        <div class="table__header">';
        echo "            <h1>Proposals for $fullName</h1>";
        echo "<form method='get' action=''>";
        echo '            <div class="search-container">';
        echo '                <div class="input-box">';
        echo '                    <input type="text" name="keyword" placeholder="Search data">';
        echo '                    <i class="bx bx-search"></i>';
        echo '                </div>';
        echo '                <button type="submit" name="submit" value="Search">Search </button>';
        echo '<div class="isi register-link">';
        echo '    <button type="button" class="add-new-button" onclick="window.location.href=\'home.php\'">Back</button>';
        echo '</div>';
        echo '            </div>';
        echo "</form>";

        if ($keyword == "") {
            $proposalQuery = "
                SELECT t.name AS Team, jp.description AS Description, jp.status AS Status
                FROM team t
                INNER JOIN join_proposal jp ON t.idteam = jp.idteam
                WHERE jp.idmember = '$idmember'
            ";
        } else {
            $param = "%$keyword%";
            $proposalQuery = "
                SELECT t.name AS Team, jp.description AS Description, jp.status AS Status
                FROM team t
                INNER JOIN join_proposal jp ON t.idteam = jp.idteam
                WHERE jp.idmember = '$idmember'
                AND (jp.description LIKE ? OR t.name LIKE ? OR jp.status LIKE ?)
            ";
        }

        $stmt = $conn->prepare($proposalQuery);
        if ($keyword != "") {
            $stmt->bind_param("sss", $param, $param, $param);
        }
        $stmt->execute();
        $proposalResult = $stmt->get_result();

        echo '        </div>';
        echo '        <div class="table__body">';
        echo '            <table>';
        echo '                <thead>';
        echo '                    <tr>';
        echo '                        <th>Team</th>';
        echo '                        <th>Reason</th>';
        echo '                        <th>Status</th>';
        echo '                    </tr>';
        echo '                </thead>';
        echo '                <tbody>';

        if ($proposalResult->num_rows > 0) {
            while ($row = $proposalResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Team'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No proposals found for $fullName</td></tr>";
        }

        echo '                </tbody>';
        echo '            </table>';
        echo '        </div>';

        echo '    </main>';
        echo '</div>';
    
        $stmt->close();
        $conn->close();
    ?>
</body>
</html>
