<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal</title>
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
        if ($koneksi->connect_errno) {
            echo "Koneksi Failed: " . $koneksi->connect_error;
        } 
        $keyword = "";
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
        }

        echo '<div class="main">';
        echo '    <main class="table">';
        echo '        <div class="table__header">';
        echo '            <h1>Proposal</h1>';
        echo "<form method='get' action=''>";
        echo '            <div class="search-container">';
        echo '                <div class="input-box">';
        echo '                    <input type="text" name="keyword" placeholder="Search data">';
        echo '                    <i class="bx bx-search"></i>';
        echo '                </div>';
        echo '                <button type="submit" name="submit" value="Search">Search </button>';
        echo '            </div>';
        echo '        </div>';
        echo "</form>";
        if($keyword == "") {
            $sql = "SELECT jp.*,concat(m.fname,' ',m.lname) as member,t.name as team FROM join_proposal jp
                    inner join member m on m.idmember = jp.idmember 
                    inner join team t on jp.idteam = t.idteam where jp.status='waiting'";
            $stmt = $koneksi->prepare($sql);
        }
        else {
            $param = "%$keyword%";
            $sql = "SELECT jp.*,concat(m.fname,' ',m.lname) as member,t.name as team FROM join_proposal jp
                    inner join member m on m.idmember = jp.idmember 
                    inner join team t on jp.idteam = t.idteam where concat(m.fname,' ',m.lname) && jp.status='waiting' like ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("s", $param);
        }
    $stmt->execute();

    $result = $stmt->get_result();

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
        $sql = "SELECT jp.*,concat(m.fname,' ',m.lname) as member,t.name as team FROM join_proposal jp
                inner join member m on m.idmember = jp.idmember 
                inner join team t on jp.idteam = t.idteam where concat(m.fname,' ',m.lname) like ? && jp.status='waiting' limit ?,?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sii", $param,$start,$perpage);
        $stmt->execute();
        $result = $stmt->get_result();

  
        echo '        <div class="table__body">';
        echo '            <table>';
        echo '                <thead>';
        echo '                    <tr>
                <th>ID</th>
                <th>Member Name</th>
                <th>Join Team</th>
                <th>Description</th>
                <th >Action</th>
            </tr>';
        echo '                </thead>';
        echo '                <tbody>';
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['idjoin_proposal'] . "</td>";
            echo "<td>" . $row['member'] . "</td>";
            echo "<td>" . $row['team'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
    
            $idjoin_proposal = $row['idjoin_proposal'];
            $idteam = $row['idteam'];
            $idmember = $row['idmember'];
            $description = $row['description'];
                echo "<td>
                <form method='POST' action='teammembersadd_proses.php'>
                    <input type='hidden' name='idteam' value='" . $idteam . "'>
                    <input type='hidden' name='idmember' value='" . $idmember . "'>
                    <input type='hidden' name='idjoin_proposal' value='" . $idjoin_proposal . "'>
                    <input type='hidden' name='description' value='" . $description . "'>
                    <button type='confirm' class = 'icon-button team' name='submit' value='Add to Team' onclick='return confirm(\"Apakah Anda yakin ingin menerima proposal ini?\")'>Accept</button>
                </form>
                <br>

                <form method='POST' action='teammembersreject_proses.php'>
                <input type='hidden' name='idteam' value='" . $idteam . "'>
                <input type='hidden' name='idmember' value='" . $idmember . "'>
                <input type='hidden' name='idjoin_proposal' value='" . $idjoin_proposal . "'>
                <input type='hidden' name='description' value='" . $description . "'>
                <button type='confirm' class = 'icon-button trash' name='submit' value='reject' onclick='return confirm(\"Apakah Anda yakin ingin menolak proposal ini?\")'>Reject</button>
            </form>
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
            echo "<a class='pagination-btn' href='proposal.php?p=$prev&keyword=$keyword&rows=$perpage'><</a> ";
        }
        echo "<a class='pagination-btn' href='proposal.php?p=1&keyword=$keyword&rows=$perpage'>First</a> ";
        for($i=1;$i<=$totalpage;$i++){
            echo "<a  class='pagination-btn' href='proposal.php?p=$i&keyword=$keyword&rows=$perpage'>$i</a> ";
        }
        echo "<a class='pagination-btn' href='proposal.php?p=$totalpage&keyword=$keyword&rows=$perpage'>Last</a> ";
        if ($page<$totalpage){
            $next = $page+1;
            echo "<a class='pagination-btn' href='proposal.php?p=$next&keyword=$keyword&rows=$perpage'>></a> ";
        }
        echo "<br><br>";
        echo '    </main>';
        echo '</div>';
        $stmt->close();
        $koneksi->close();
        ?>    
</body>
</html>