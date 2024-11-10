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
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/game/cGame.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');

    $db = new Database();
    $dbConnection = $db->getConnection();
    $game = new Game($dbConnection);


    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $currentPage = isset($_GET['p']) ? (int) $_GET['p'] : 1;
    $perPage = isset($_GET['rows']) ? (int) $_GET['rows'] : 5;

    $paginationData = $game->getPaginationData($currentPage, $perPage, $keyword);
    $games = $game->getGames($keyword, ($currentPage - 1) * $perPage, $perPage);

    echo '<div class="main">';
    echo '    <main class="table">';
    echo '        <div class="table__header">';
    echo '            <h1>Games</h1>';
    echo "<form method='get' action=''>";
    echo '            <div class="search-container">';
    echo '                <div class="input-box">';
    echo '                    <input type="text" name="keyword" placeholder="Search data" value="' . htmlspecialchars($keyword) . '">';
    echo '                    <i class="bx bx-search"></i>';
    echo '                </div>';
    echo '                <button type="submit" name="submit" value="Search">Search</button>';
    echo '            </div>';
    echo "</form>";

    echo '            <a href="/fsp/projek/me/admin/game/gameAdd.php">';
    echo '                <button class="add-new-button">Add game';
    echo '                    <i class="bx bx-plus"></i>';
    echo '                </button>';
    echo '            </a>';
    echo '        </div>';

    echo '        <div class="table__body">';
    echo '            <table>';
    echo '                <thead>';
    echo '                    <tr>';
    echo '                        <th>ID</th>';
    echo '                        <th>Game</th>';
    echo '                        <th>Description</th>';
    echo '                        <th>Action</th>';
    echo '                    </tr>';
    echo '                </thead>';
    echo '                <tbody>';

    foreach ($games as $row) {
        $idgame = $row['idgame'];
        echo "<tr>";
        echo "<td>" . $row['idgame'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>
                    <a href='/fsp/projek/me/admin/game/gameEdit.php?id=$idgame'>
                        <button class='icon-button edit'>
                            <i class='bx bxs-edit-alt'></i>
                        </button>
                    </a>
                    <a href='/fsp/projek/me/admin/game/gameDelete.php?id=$idgame' onclick='return confirm(\"Apakah Anda yakin ingin menghapus game ini?\")'>
                        <button class='icon-button trash'>
                            <i class='bx bxs-trash-alt'></i>
                        </button>
                    </a></td>";
        echo "</tr>";
    }

    echo '                </tbody>';
    echo '            </table>';
    echo '        </div>';

    //pagingg
    echo '        <div class="pagination-container">';
    echo '            <form method="get" action="">';
    echo '                <label for="rows">Rows per page: </label>';
    echo '                <select name="rows" id="rows" onchange="this.form.submit()">';
    echo '                    <option value="5"' . ($perPage == 5 ? ' selected' : '') . '>5</option>';
    echo '                    <option value="10"' . ($perPage == 10 ? ' selected' : '') . '>10</option>';
    echo '                    <option value="25"' . ($perPage == 25 ? ' selected' : '') . '>25</option>';
    echo '                    <option value="50"' . ($perPage == 50 ? ' selected' : '') . '>50</option>';
    echo '                </select>';
    echo '                <input type="hidden" name="keyword" value="' . htmlspecialchars($keyword) . '">';
    echo '            </form>';

    echo $game->getPaginationLinks($currentPage, $paginationData['totalPages'], $keyword, $perPage);

    echo '        </div>';
    echo '    </main>';
    echo '</div>';

    $dbConnection->close();
    ?>
</body>

</html>