<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
    <style>
        .pagination-btn {
            padding: 5px 10px;
            border: 1px solid #fff;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/aside.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/proposal/cProposal.php');

    $db = new Database();
    $dbConnection = $db->getConnection();
    $proposalClass = new Proposal($dbConnection);

    $keyword = $_GET['keyword'] ?? '';
    $perpage = $_GET['rows'] ?? 5;
    $page = $_GET['p'] ?? 1;
    $start = ($page - 1) * $perpage;

    $proposals = $proposalClass->getProposals($keyword, $start, $perpage);
    $paginationData = $proposalClass->getPaginationData($page, $perpage, $keyword);

    echo '<div class="main">';
    echo '    <main class="table">';
    echo '        <div class="table__header">';
    echo '            <h1>Proposal</h1>';
    echo "            <form method='get' action=''>";
    echo '                <div class="search-container">';
    echo '                    <div class="input-box">';
    echo '                        <input type="text" name="keyword" placeholder="Search data" value="' . htmlspecialchars($keyword) . '">';
    echo '                    </div>';
    echo '                    <button type="submit" name="submit" value="Search">Search</button>';
    echo '                </div>';
    echo '            </form>';
    echo '        </div>';

    echo '        <div class="table__body">';
    echo '            <table>';
    echo '                <thead>';
    echo '                    <tr>';
    echo '                        <th>ID</th>';
    echo '                        <th>Member Name</th>';
    echo '                        <th>Join Team</th>';
    echo '                        <th>Description</th>';
    echo '                        <th>Action</th>';
    echo '                    </tr>';
    echo '                </thead>';
    echo '                <tbody>';

    foreach ($proposals as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['idjoin_proposal']) . "</td>";
        echo "<td>" . htmlspecialchars($row['member']) . "</td>";
        echo "<td>" . htmlspecialchars($row['team']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td>
                <form method='POST' action='teamMembersAdd.php' style='display:inline;'>
                    <input type='hidden' name='idteam' value='" . htmlspecialchars($row['idteam']) . "'>
                    <input type='hidden' name='idmember' value='" . htmlspecialchars($row['idmember']) . "'>
                    <input type='hidden' name='idjoin_proposal' value='" . htmlspecialchars($row['idjoin_proposal']) . "'>
                    <button type='submit' name='submit' class='icon-button team' style='color: white;'>Accept</button>
                </form>
                <form method='POST' action='teamMembersReject.php' style='display:inline;'>
                    <input type='hidden' name='idjoin_proposal' value='" . htmlspecialchars($row['idjoin_proposal']) . "'>
                    <button type='submit' name='submit' class='icon-button trash' style='color: white;'>Reject</button>
                </form>
              </td>";
        echo "</tr>";
    }

    echo '                </tbody>';
    echo '            </table>';
    echo '        </div>';

    echo '        <div class="pagination-container">';
    echo "            <form method='get' action=''>";
    echo '                <label for="rows">Rows per page: </label>';
    echo '                <select name="rows" id="rows" onchange="this.form.submit()">';
    echo '                    <option value="5"' . ($perpage == 5 ? ' selected' : '') . '>5</option>';
    echo '                    <option value="10"' . ($perpage == 10 ? ' selected' : '') . '>10</option>';
    echo '                    <option value="25"' . ($perpage == 25 ? ' selected' : '') . '>25</option>';
    echo '                    <option value="50"' . ($perpage == 50 ? ' selected' : '') . '>50</option>';
    echo '                </select>';
    echo '                <input type="hidden" name="keyword" value="' . htmlspecialchars($keyword) . '">';
    echo '            </form>';

    if ($paginationData['hasPrev']) {
        $prevPage = $paginationData['prevPage'];
        echo "<a class='pagination-btn' href='proposal.php?p=$prevPage&keyword=" . urlencode($keyword) . "&rows=$perpage'><</a> ";
    }

    echo "<a class='pagination-btn' href='proposal.php?p=1&keyword=" . urlencode($keyword) . "&rows=$perpage'>First</a> ";

    for ($i = 1; $i <= $paginationData['totalPages']; $i++) {
        echo "<a class='pagination-btn' href='proposal.php?p=$i&keyword=" . urlencode($keyword) . "&rows=$perpage'>$i</a> ";
    }

    echo "<a class='pagination-btn' href='proposal.php?p=" . $paginationData['lastPage'] . "&keyword=" . urlencode($keyword) . "&rows=$perpage'>Last</a> ";

    if ($paginationData['hasNext']) {
        $nextPage = $paginationData['nextPage'];
        echo "<a class='pagination-btn' href='proposal.php?p=$nextPage&keyword=" . urlencode($keyword) . "&rows=$perpage'>></a> ";
    }

    echo '        </div>';
    echo '    </main>';
    echo '</div>';

    $dbConnection->close();
    ?>
</body>

</html>
