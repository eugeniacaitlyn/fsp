<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
    <style>
        .pagination-btn {
            display: inline-block;
            padding: 5px 5px;
            margin: 5px;
            text-decoration: none;
            color: #000; 
            border: 2px solid #000; 
            border-radius: 5px; 
            background-color: #f9f9f9; 
            }
        table {
                border-collapse: collapse;
                width: 100%;
        }
        th, td {
                padding: 8px;
                text-align: left;
                border: 1px solid #ddd;
            }
        th {
                background-color: #f2f2f2;
            }
    </style>
</head>
<body>
    
</body>
</html>
<div class="team-select">
    <?php
        $koneksi = new mysqli("localhost", "root", "", "capstone");
        $keyword = "";
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
        }

        echo "<form method='get' action=''>";
        echo "Search: <input type='text' name='keyword' ;>";
        echo "<input type='submit' name='submit' value='Search'>";
        echo"<select id='halaman' name='halaman' style='margin-left:8px'>";
        echo"<option value='5' >5</option>";
        echo"<option value='10' >10</option>";
        echo"<option value='25' >25</option>";
        echo"<option value='50' >50</option>";
        echo"</select>";
        echo "</form>";

        if($keyword == "") {
            $sql = "select t.idteam, t.name as Team, g.name as Game
                from team t inner join game g
                where t.idgame = g.idgame";
            $stmt = $koneksi->prepare($sql);
        }
        else {
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
    $perpage=5;
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
        $sql = "SELECT t.idteam, t.name AS Team, g.name AS Game,
                    GROUP_CONCAT(DISTINCT ev.name SEPARATOR ', ') AS Events,
                    GROUP_CONCAT(DISTINCT CONCAT(ach.name, ' ', ach.description) SEPARATOR ', ') AS Achievement
                FROM team t 
                LEFT JOIN game g ON t.idgame = g.idgame 
                LEFT JOIN event_teams evt ON t.idteam = evt.idteam 
                LEFT JOIN event ev ON ev.idevent = evt.idevent  
                LEFT JOIN achievement ach ON t.idTeam = ach.idteam
                WHERE t.name LIKE ? 
                GROUP BY t.idteam
                ORDER BY t.idteam ASC 
                LIMIT ?, ?
                ";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sii", $param,$start,$perpage);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($page>1){
            $prev = $page-1;
            echo "<a class='pagination-btn' href='teamselect.php?p=$prev&keyword=$keyword'><</a> ";
        }
        echo "<a class='pagination-btn' href='teamselect.php?p=1&keyword=$keyword'>First</a> ";
        //TAMPILKAN PAGE
        for($i=1;$i<=$totalpage;$i++){
            echo "<a  class='pagination-btn' href='teamselect.php?p=$i&keyword=$keyword'>$i</a> ";
        }
        
        echo "<a class='pagination-btn' href='teamselect.php?p=$totalpage&keyword=$keyword'>Last</a> ";
        if ($page<$totalpage){
            $next = $page+1;
            echo "<a class='pagination-btn' href='teamselect.php?p=$next&keyword=$keyword'>></a> ";
        }
        echo "<br><br>";

        echo "<table border='1'>
                <tr>
                    <th>Id Team</th>
                    <th>Team Name</th>
                    <th>Game</th>
                    <th>Event</th>
                    <th>Achievement</th>
                    <th colspan = 3 >Action</th>
                </tr>
            ";
        while($row = $result->fetch_assoc()){
            $idteam = $row['idteam'];
            echo "<tr>";
            echo "<td>".$row['idteam']."</td>";
            echo "<td>".$row['Team']."</td>";
            echo "<td>".$row['Game']."</td>";

            $events = explode(', ', $row['Events']);
            if($row['Events'] == "") {
                echo "<td>-</td>";
            }
            else{
                echo "<td>";
                foreach ($events as $event) 
                echo "<li>" . htmlspecialchars(trim($event)) . "</li>";
                echo "</td>";
            }

            
            $achievement = explode(', ', $row['Achievement']);
            if($row['Achievement'] == "") {
                echo "<td>-</td>";
            }
            else{
                echo "<td>";
                foreach ($achievement as $achievement) 
                echo "<li>" . htmlspecialchars(trim($achievement)) . "</li>";
                echo "</td>";
            }
            
            echo "<td><a class='pagination-btn' href ='teammembersselect.php?id=$idteam'>View Members</a></td>";
            echo "<td><a class='pagination-btn' href ='teamedit.php?id=$idteam'>Edit</td>";
            echo "<td><a class='pagination-btn' href ='teamdelete_proses.php?id=$idteam' onclick='return confirm(\"Apakah Anda yakin ingin menghapus team ini?\")'>Hapus</td>";
        
            echo "</tr>";
        }
        echo "</table>";

        $stmt->close();
        $koneksi->close();
    ?>
    <br>
    <a class='pagination-btn' href="teaminsert.php">Insert New Team</a>
    <br>
    <a class='pagination-btn' href="adminhome.php">Back to Home</a>
</div>