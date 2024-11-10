<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
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
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/team/cTeam.php');

    $db = new Database();
    $dbConnection = $db->getConnection();

    $team = new Team($dbConnection);

    $keyword = $_GET['keyword'] ?? '';
    $perpage = $_GET['rows'] ?? 5;
    $page = $_GET['p'] ?? 1;
    $start = ($page - 1) * $perpage;

    $teams = $team->getTeams($keyword, $start, $perpage);
    $paginationData = $team->getPaginationData($page, $perpage, $keyword);

    echo '<div class="main">';
    echo '    <main class="table">';
    echo '        <div class="table__header">';
    echo '            <h1>Teams</h1>';
    echo "<form method='get' action=''>";
    echo '            <div class="search-container">';
    echo '                <div class="input-box">';
    echo '                    <input type="text" name="keyword" placeholder="Search data" value="' . htmlspecialchars($keyword) . '">';
    echo '                    <i class="bx bx-search"></i>';
    echo '                </div>';
    echo '                <button type="submit" name="submit" value="Search">Search </button>';
    echo '            </div>';
    echo "</form>";

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
    echo '                        <th>ID</th>';
    echo '                        <th>Team Name</th>';
    echo '                        <th>Game</th>';
    echo '                        <th>Event</th>';
    echo '                        <th>Achievement</th>';
    echo '                        <th>Action</th>';
    echo '                    </tr>';
    echo '                </thead>';
    echo '                <tbody>';
    foreach ($teams as $row) {
        $idteam = $row['idteam'];
        echo "<tr>";
        echo "<td>" . $row['idteam'] . "</td>";
        echo "<td>" . $row['Team'] . "</td>";
        echo "<td>" . $row['Game'] . "</td>";

        $events = empty($row['Events']) ? '-' : '<li>' . implode('</li><li>', array_map('htmlspecialchars', explode(', ', $row['Events']))) . '</li>';
        echo "<td><ul>$events</ul></td>";

        $achievements = empty($row['Achievement']) ? '-' : '<li>' . implode('</li><li>', array_map('htmlspecialchars', explode(', ', $row['Achievement']))) . '</li>';
        echo "<td><ul>$achievements</ul></td>";


        echo "<td>
                    <a href='/fsp/projek/me/admin/member/member.php?id=$idteam'>
                        <button class='icon-button team'>
                            <i class='bx bxs-user'></i>
                        </button>
                    </a>
                    <a href='/fsp/projek/me/admin/team/teamEdit.php?id=$idteam'>
                        <button class='icon-button edit'>
                            <i class='bx bxs-edit-alt'></i>
                        </button>
                    </a>
                    <a href='/fsp/projek/me/admin/team/teamDelete.php?id=$idteam' onclick='return confirm(\"Apakah Anda yakin ingin menghapus team ini?\")'>
                        <button class='icon-button trash'>
                            <i class='bx bxs-trash-alt'></i>
                        </button>
                    </a>
                </td>";

        echo "</tr>";
    }

    echo '                </tbody>';
    echo '            </table>';
    echo '        </div>';

    echo '        <div class="pagination-container">';
    echo '        <div class="pagination-container">';
    echo '            <form method="get" action="">';
    echo '                <label for="rows">Rows per page: </label>';
    echo '                <select name="rows" id="rows" onchange="this.form.submit()">';
    echo '                    <option value="5" ' . ($perpage == 5 ? 'selected' : '') . '>5</option>';
    echo '                    <option value="10" ' . ($perpage == 10 ? 'selected' : '') . '>10</option>';
    echo '                    <option value="25" ' . ($perpage == 25 ? 'selected' : '') . '>25</option>';
    echo '                    <option value="50" ' . ($perpage == 50 ? 'selected' : '') . '>50</option>';
    echo '                </select>';
    echo '                <input type="hidden" name="keyword" value="' . htmlspecialchars($keyword) . '">';
    echo '            </form>';
    echo '        </div>';

    if ($paginationData['hasPrev']) {
        $prevPage = $paginationData['prevPage'];
        echo "<a class='pagination-btn' href='team.php?p=$prevPage&keyword=$keyword&rows=$perpage'><</a> ";
    }
    echo "<a class='pagination-btn' href='team.php?p=1&keyword=$keyword&rows=$perpage'>First</a> ";
    for ($i = 1; $i <= $paginationData['totalPages']; $i++) {
        echo "<a class='pagination-btn' href='team.php?p=$i&keyword=$keyword&rows=$perpage'>$i</a> ";
    }
    echo "<a class='pagination-btn' href='team.php?p=" . $paginationData['lastPage'] . "&keyword=$keyword&rows=$perpage'>Last</a> ";
    if ($paginationData['hasNext']) {
        $nextPage = $paginationData['nextPage'];
        echo "<a class='pagination-btn' href='team.php?p=$nextPage&keyword=$keyword&rows=$perpage'>></a> ";
    }

    echo "<br><br>";
    echo '    </main>';
    echo '</div>';

    $dbConnection->close();
    ?>
</body>

</html>