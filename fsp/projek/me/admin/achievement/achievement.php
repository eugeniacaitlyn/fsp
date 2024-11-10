<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievement</title>
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
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/achievement/cAchievement.php');

    $db = new Database();
    $dbConnection = $db->getConnection();

    $achievement = new Achievement($dbConnection);

    $keyword = $_GET['keyword'] ?? "";
    $perpage = $_GET['rows'] ?? 5;
    $page = $_GET['p'] ?? 1;
    $start = ($page - 1) * $perpage;

    $totalAchievements = $achievement->getTotalAchievements($keyword);
    $totalpage = ceil($totalAchievements / $perpage);
    $achievements = $achievement->getAchievements($keyword, $start, $perpage);

    echo '<div class="main">';
    echo '    <main class="table">';
    echo '        <div class="table__header">';
    echo '            <h1>Achievement</h1>';
    echo '            <form method="get" action="">';
    echo '                <div class="search-container">';
    echo '                    <div class="input-box">';
    echo '                        <input type="text" name="keyword" placeholder="Search data" value="' . htmlspecialchars($keyword) . '">';
    echo '                    </div>';
    echo '                    <button type="submit" name="submit" value="Search">Search</button>';
    echo '                </div>';
    echo '            </form>';
    echo '            <a href="/fsp/projek/me/admin/achievement/achievementAdd.php">';
    echo '                <button class="add-new-button">Add Achievement<i class="bx bx-plus"></i></button>';
    echo '            </a>';
    echo '        </div>';
    echo '        <div class="table__body">';
    echo '            <table>';
    echo '                <thead>';
    echo '                    <tr>';
    echo '                        <th>ID</th>';
    echo '                        <th>Name Event</th>';
    echo '                        <th>Team</th>';
    echo '                        <th>Date</th>';
    echo '                        <th>Description</th>';
    echo '                        <th>Action</th>';
    echo '                    </tr>';
    echo '                </thead>';
    echo '                <tbody>';

    foreach ($achievements as $row) {
        echo '<tr>';
        echo '    <td>' . htmlspecialchars($row['idachievement']) . '</td>';
        echo '    <td>' . htmlspecialchars($row['name']) . '</td>';
        echo '    <td>' . htmlspecialchars($row['team']) . '</td>';

        $rilis = date("d F Y", strtotime($row['date']));
        echo '    <td class="date-column">' . htmlspecialchars($rilis) . '</td>';

        echo '    <td>' . htmlspecialchars($row['description']) . '</td>';
        $idachievement = $row['idachievement'];
        echo '    <td>';
        echo '        <a href="/fsp/projek/me/admin/achievement/achievementEdit.php?id=' . $idachievement . '">';
        echo '            <button class="icon-button edit"><i class="bx bxs-edit-alt"></i></button>';
        echo '        </a>';
        echo '        <a href="/fsp/projek/me/admin/achievement/achievementDelete.php?id=' . $idachievement . '" onclick="return confirm(\'Are you sure you want to delete this achievement?\')">';
        echo '            <button class="icon-button trash"><i class="bx bxs-trash-alt"></i></button>';
        echo '        </a>';
        echo '    </td>';
        echo '</tr>';
    }

    echo '                </tbody>';
    echo '            </table>';
    echo '        </div>';

    echo '        <div class="pagination-container">';
    echo '            <form method="get" action="">';
    echo '                <label for="rows">Rows per page: </label>';
    echo '                <select name="rows" id="rows" onchange="this.form.submit()">';
    echo '                    <option value="5"' . ($perpage == 5 ? ' selected' : '') . '>5</option>';
    echo '                    <option value="10"' . ($perpage == 10 ? ' selected' : '') . '>10</option>';
    echo '                    <option value="25"' . ($perpage == 25 ? ' selected' : '') . '>25</option>';
    echo '                    <option value="50"' . ($perpage == 50 ? ' selected' : '') . '>50</option>';
    echo '                </select>';
    echo '                <input type="hidden" name="keyword" value="' . htmlspecialchars($keyword) . '">';
    echo '            </form>';

    echo $achievement->getPaginationLinks($page, $totalpage, $keyword, $perpage);

    echo '        </div>';
    echo '    </main>';
    echo '</div>';

    $dbConnection->close();
    ?>
</body>
</html>
