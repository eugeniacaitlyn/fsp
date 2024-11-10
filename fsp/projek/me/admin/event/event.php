<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
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
        include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/event/cEvent.php');

        $db = new Database();
        $dbConnection = $db->getConnection();
        $event = new Event($dbConnection);

        $keyword = $_GET['keyword'] ?? '';
        $perpage = $_GET['rows'] ?? 5;
        $page = $_GET['p'] ?? 1;
        $start = ($page - 1) * $perpage;

        $events = $event->getEvents($keyword, $start, $perpage);
        $paginationData = $event->getPaginationData($page, $perpage, $keyword);

        echo '<div class="main">';
        echo '    <main class="table">';
        echo '        <div class="table__header">';
        echo '            <h1>Event</h1>';
        echo "<form method='get' action=''>";
        echo '            <div class="search-container">';
        echo '                <div class="input-box">';
        echo '                    <input type="text" name="keyword" placeholder="Search data" value="' . htmlspecialchars($keyword) . '">';
        echo '                    <i class="bx bx-search"></i>';
        echo '                </div>';
        echo '                <button type="submit" name="submit" value="Search">Search</button>';
        echo '            </div>';
        echo "</form>";
        echo '            <a href="/fsp/projek/me/admin/event/eventAdd.php">';
        echo '                <button class="add-new-button">Add event';
        echo '                    <i class="bx bx-plus"></i>';
        echo '                </button>';
        echo '            </a>';
        echo '        </div>';

        echo '        <div class="table__body">';
        echo '            <table>';
        echo '                <thead>';
        echo '                    <tr>';
        echo '                        <th>ID</th>';
        echo '                        <th>Name</th>';
        echo '                        <th>Date</th>';
        echo '                        <th>Team</th>';
        echo '                        <th>Description</th>';
        echo '                        <th colspan="3">Action</th>';
        echo '                    </tr>';
        echo '                </thead>';
        echo '                <tbody>';

        foreach ($events as $row) {
            echo "<tr>";
            echo "<td>" . $row['idevent'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";

            $rilis = date("d F Y", strtotime($row['date']));
            echo "<td class='date-column'>" . $rilis . "</td>";

            $teams = explode(', ', $row['TEAMS']);
            echo "<td>";
            if (empty($row['TEAMS'])) {
                echo "-";
            } else {
                foreach ($teams as $team) {
                    echo "<li>" . htmlspecialchars(trim($team)) . "</li>";
                }
            }
            echo "</td>";

            echo "<td>" . $row['description'] . "</td>";
            $idevent = $row['idevent'];

            echo "<td>
                    <a href='/fsp/projek/me/admin/event/eventEdit.php?id=$idevent'>
                        <button class='icon-button edit'>
                            <i class='bx bxs-edit-alt'></i>
                        </button>
                    </a>
                    <a href='/fsp/projek/me/admin/event/eventDelete.php?id=$idevent' onclick='return confirm(\"Are you sure you want to delete this event?\")'>
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
            echo "<a class='pagination-btn' href='event.php?p=$prevPage&keyword=$keyword&rows=$perpage'><</a> ";
        }

        echo "<a class='pagination-btn' href='event.php?p=1&keyword=$keyword&rows=$perpage'>First</a> ";
        for ($i = 1; $i <= $paginationData['totalPages']; $i++) {
            echo "<a class='pagination-btn' href='event.php?p=$i&keyword=$keyword&rows=$perpage'>$i</a> ";
        }

        echo "<a class='pagination-btn' href='event.php?p=" . $paginationData['lastPage'] . "&keyword=$keyword&rows=$perpage'>Last</a> ";

        if ($paginationData['hasNext']) {
            $nextPage = $paginationData['nextPage'];
            echo "<a class='pagination-btn' href='event.php?p=$nextPage&keyword=$keyword&rows=$perpage'>></a> ";
        }

        echo "<br><br>";
        echo '    </main>';
        echo '</div>';

        $dbConnection->close();
    ?>
</body>
</html>
