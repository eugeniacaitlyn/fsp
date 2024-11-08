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
        include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');
        $koneksi = new mysqli("localhost", "root", "", "capstone");
        $keyword = "";
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
        }

        echo '<div class="main">';
        echo '    <main class="table">';
        echo '        <div class="table__header">';
        echo '            <h1>Games</h1>';
        echo "<form method='get' action=''>";
        echo '            <div class="search-container">';
        echo '                <div class="input-box">';
        echo '                    <input type="text" name="keyword" placeholder="Search data">';
        echo '                    <i class="bx bx-search"></i>';
        echo '                </div>';
        echo '                <button type="submit" name="submit" value="Search">Search </button>';
        echo '            </div>';
        echo "</form>";
        if($keyword == "") {
            $sql = "select * from game";
            $stmt = $koneksi->prepare($sql);
        }
        else {
            $param = "%$keyword%";
            $sql = "select * from game WHERE name Like ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("s", $param);
        }
        $stmt->execute();
    
        //setiap ada select harus ada get_result
        $result = $stmt->get_result();
        //PAGING
    $perpage=5;
    if (isset($_GET['rows'])) {
        $perpage = (int)$_GET['rows'];  
    }
    $totaldata=$result->num_rows;
    $totalpage=ceil($totaldata/$perpage);
    $page=1;

    if (isset($_GET['p'])){
        $page = $_GET['p'];
    }
    else{
        $page=1;
    }
    
    $start=($page-1)*$perpage;

    $param = "%$keyword%";
        $sql = "SELECT * FROM game WHERE name Like ? limit ?,?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sii", $param,$start,$perpage);
        $stmt->execute();
        $result = $stmt->get_result();

        
        
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
        echo '                        <th>Desc</th>';
        echo '                        <th >Action</th>';
        echo '                    </tr>';
        echo '                </thead>';
        echo '                <tbody>';
        while($row = $result->fetch_assoc()){
            $idgame = $row['idgame'];
            echo "<tr>";
            echo "<td>".$row['idgame']."</td>";
            echo "<td>".$row['name']."</td>";
            echo "<td>".$row['description']."</td>";
            echo "<td>
                    <a href ='/fsp/projek/me/admin/game/gameEdit.php?id=$idgame'>
                        <button class='icon-button edit'>
                            <i class='bx bxs-edit-alt'></i>
                        </button>
                    </a>
                    <a href ='/fsp/projek/me/admin/game/gameDelete.php?id=$idgame' onclick='return confirm(\"Apakah Anda yakin ingin menghapus game ini?\")'>
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
        echo '                    <option value="5"'.($perpage == 5 ? ' selected' : '').'>5</option>';
        echo '                    <option value="10"'.($perpage == 10 ? ' selected' : '').'>10</option>';
        echo '                    <option value="25"'.($perpage == 25 ? ' selected' : '').'>25</option>';
        echo '                    <option value="50"'.($perpage == 50 ? ' selected' : '').'>50</option>';
        echo '                </select>';
        echo '                <input type="hidden" name="keyword" value="'. htmlspecialchars($keyword) .'">';
        echo '            </form>';
        echo '        </div>';

        //TAMPILKAN PAGE
        if ($page>1){
            $prev = $page-1;
            echo "<a class='pagination-btn' href='game.php?p=$prev&keyword=$keyword&rows=$perpage'><</a> ";
        }
        echo "<a class='pagination-btn' href='game.php?p=1&keyword=$keyword&rows=$perpage'>First</a> ";
        for($i=1;$i<=$totalpage;$i++){
            echo "<a  class='pagination-btn' href='game.php?p=$i&keyword=$keyword&rows=$perpage'>$i</a> ";
        }
        echo "<a class='pagination-btn' href='game.php?p=$totalpage&keyword=$keyword&rows=$perpage'>Last</a> ";
        if ($page<$totalpage){
            $next = $page+1;
            echo "<a class='pagination-btn' href='game.php?p=$next&keyword=$keyword&rows=$perpage'>></a> ";
        }
        echo "<br><br>";
        echo '    </main>';
        echo '</div>';
        $stmt->close();
        $koneksi->close();
        ?>    
</body>
</html>