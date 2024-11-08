<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<style>
    .pagination-btn {
        padding: 5px 10px;
        border: 1px solid #fff;
        text-decoration: none;
        color: #fff;
        border-radius: 5px;
    }
</style>

<body>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/aside.php');
    $koneksi = new mysqli("localhost", "root", "", "capstone");
    $keyword = "";
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
    }

    echo '<div class="main">';
    echo '    <main class="table">';
    echo '        <div class="table__header">';
    echo '            <h1>Teams</h1>';
    echo "<form method='get' action=''>";
    echo '            <div class="search-container">';
    echo '                <div class="input-box">';
    echo '                    <input type="text" name="keyword" placeholder="Search data">';
    echo '                    <i class="bx bx-search"></i>';
    echo '                </div>';
    echo '                <button type="submit" name="submit" value="Search">Search </button>';
    echo '            </div>';
    echo "</form>";
    if ($keyword == "") {
        $sql = "select t.idteam, t.name as Team, g.name as Game
                from team t inner join game g
                where t.idgame = g.idgame";
        $stmt = $koneksi->prepare($sql);
    } else {
        $param = "%$keyword%";
        $sql = "select t.idteam, t.name as Team, g.name as Game
                from team t inner join game g
                where t.idgame = g.idgame && t.name like ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("s", $param);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    //PAGING
    $perpage = 5;
    if (isset($_GET['rows'])) {
        $perpage = (int) $_GET['rows'];
    }
    $totaldata = $result->num_rows;
    $totalpage = ceil($totaldata / $perpage);
    $page = 1;

    if (isset($_GET['p'])) {
        $page = $_GET['p'];
    } else {
        $page = 1;
    }

    $start = ($page - 1) * $perpage;

    $param = "%$keyword%";
    $sql = "SELECT t.idteam, t.name AS Team, g.name AS Game,
    GROUP_CONCAT(DISTINCT ev.name SEPARATOR ', ') AS Events,
    GROUP_CONCAT(DISTINCT CONCAT(ach.name, ' ', ach.description) SEPARATOR ', ') AS Achievement,
    COUNT(tm.idmember) AS member_count
        FROM team t 
        LEFT JOIN game g ON t.idgame = g.idgame 
        LEFT JOIN event_teams evt ON t.idteam = evt.idteam 
        LEFT JOIN event ev ON ev.idevent = evt.idevent  
        LEFT JOIN achievement ach ON t.idTeam = ach.idteam
        LEFT JOIN team_members tm ON t.idteam = tm.idteam
        WHERE t.name LIKE ? 
        GROUP BY t.idteam
        ORDER BY t.idteam ASC 
        LIMIT ?, ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("sii", $param, $start, $perpage);
    $stmt->execute();
    $result = $stmt->get_result();



    echo '            <a href="/fsp/projek/me/admin/team/teamAdd.php">';
    echo '                <button class="add-new-button">Add team';
    echo '                    <i class="bx bx-plus"></i>';
    echo '                </button>';
    echo '            </a>';
    echo '        </div>';
    echo '        <div class="table__body">';
    echo '            <table>';
    echo '                <thead>';
    echo '                    <tr>';
    echo '                        <th>ID</th>
                    <th>Team Name</th>
                    <th>Game</th>
                    <th>Event</th>
                    <th>Achievement</th>';
    echo '                        <th >Action</th>';
    echo '                    </tr>';
    echo '                </thead>';
    echo '                <tbody>';
    while ($row = $result->fetch_assoc()) {
        $idteam = $row['idteam'];
        echo "<tr>";
        echo "<td>" . $row['idteam'] . "</td>";
        echo "<td>" . $row['Team'] . "</td>";
        echo "<td>" . $row['Game'] . "</td>";

        $events = explode(', ', $row['Events']);
        if ($row['Events'] == "") {
            echo "<td>-</td>";
        } else {
            echo "<td>";
            foreach ($events as $event)
                echo "<li>" . htmlspecialchars(trim($event)) . "</li>";
            echo "</td>";
        }


        $achievement = explode(', ', $row['Achievement']);
        if ($row['Achievement'] == "") {
            echo "<td>-</td>";
        } else {
            echo "<td>";
            foreach ($achievement as $achievement)
                echo "<li>" . htmlspecialchars(trim($achievement)) . "</li>";
            echo "</td>";
        }

        echo "<td>
                    <a href ='/fsp/projek/me/admin/member/member.php?id=$idteam'>
                        <button class='icon-button team'>
                            <i class='bx bxs-user'></i>
                        </button>
                    </a>
                    <a href ='/fsp/projek/me/admin/team/teamEdit.php?id=$idteam'>
                        <button class='icon-button edit'>
                            <i class='bx bxs-edit-alt'></i>
                        </button>
                    </a>
                    <a href ='/fsp/projek/me/admin/team/teamDelete.php?id=$idteam' onclick='return confirm(\"Apakah Anda yakin ingin menghapus team ini?\")'>
                        <button class='icon-button trash'>
                            <i class='bx bxs-trash-alt'></i>
                        </button>
                    </a></td>";

        echo "</tr>";
    }

    echo '                </tbody>';
    echo '            </table>';
    echo '        </div>';
    echo '        <div class="pagination-container">';
    echo '        <div class="pagination-container">';
    echo '            <form method="get" action="">';
    echo '                <label for="rows">Rows per page: </label>';
    echo '                <select name="rows" id="rows" onchange="this.form.submit()" value="$perpage"">';
    echo '                    <option value="5"' . ($perpage == 5 ? ' selected' : '') . '>5</option>';
    echo '                    <option value="10"' . ($perpage == 10 ? ' selected' : '') . '>10</option>';
    echo '                    <option value="25"' . ($perpage == 25 ? ' selected' : '') . '>25</option>';
    echo '                    <option value="50"' . ($perpage == 50 ? ' selected' : '') . '>50</option>';
    echo '                </select>';
    echo '                <input type="hidden" name="keyword" value="' . htmlspecialchars($keyword) . '">';
    echo '            </form>';
    echo '        </div>';

    //TAMPILKAN PAGE
    if ($page > 1) {
        $prev = $page - 1;
        echo "<a class='pagination-btn' href='team.php?p=$prev&keyword=$keyword&rows=$perpage'><</a> ";
    }
    echo "<a class='pagination-btn' href='team.php?p=1&keyword=$keyword&rows=$perpage'>First</a> ";
    for ($i = 1; $i <= $totalpage; $i++) {
        echo "<a  class='pagination-btn' href='team.php?p=$i&keyword=$keyword&rows=$perpage'>$i</a> ";
    }
    echo "<a class='pagination-btn' href='team.php?p=$totalpage&keyword=$keyword&rows=$perpage'>Last</a> ";
    if ($page < $totalpage) {
        $next = $page + 1;
        echo "<a class='pagination-btn' href='team.php?p=$next&keyword=$keyword&rows=$perpage'>></a> ";
    }
    echo "<br><br>";
    echo '    </main>';
    echo '</div>';
    $stmt->close();
    $koneksi->close();
    ?>
</body>

</html>