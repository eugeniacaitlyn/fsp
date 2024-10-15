<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            td.date-column {
                white-space: nowrap; 
            }
          </style>
</head>
<body>
    
</body>
</html>
<?php
    $koneksi = new mysqli("localhost", "root", "", "capstone");
    if ($koneksi->connect_errno) {
        echo "Koneksi Failed: " . $koneksi->connect_error;
    } 
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
            $sql = "SELECT ac.*, t.name as team FROM achievement ac inner join team t on ac.idteam = t.idteam";
            $stmt = $koneksi->prepare($sql);
        }
        else {
            $param = "%$keyword%";
            $sql = "SELECT ac.*, t.name as team FROM achievement ac inner join team t on ac.idteam = t.idteam where ac.name like ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("s", $param);
        }

    $stmt = $koneksi->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();

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
        $sql = "SELECT ac.*, t.name as team FROM achievement ac inner join team t on ac.idteam = t.idteam where ac.name like ? limit ?,?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sii", $param,$start,$perpage);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($page>1){
            $prev = $page-1;
            echo "<a class='pagination-btn' href='achivement.php?p=$prev&keyword=$keyword'><</a> ";
        }
        echo "<a class='pagination-btn' href='achivement.php?p=1&keyword=$keyword'>First</a> ";
        //TAMPILKAN PAGE
        for($i=1;$i<=$totalpage;$i++){
            echo "<a  class='pagination-btn' href='achivement.php?p=$i&keyword=$keyword'>$i</a> ";
        }
        
        echo "<a class='pagination-btn' href='achivement.php?p=$totalpage&keyword=$keyword'>Last</a> ";
        if ($page<$totalpage){
            $next = $page+1;
            echo "<a class='pagination-btn' href='achivement.php?p=$next&keyword=$keyword'>></a> ";
        }
        echo "<br><br>";
    

    echo "<table border='1'>
            <tr>
                <th>Code Achivement</th>
                <th>Name Event</th>
                <th>Team</th>
                <th>Date</th>
                <th>Description</th>
                <th>Action</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['idachievement'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['team'] . "</td>";

        $rilis = date("d F Y", strtotime($row['date']));
        echo "<td class='date-column'>" . $rilis . "</td>";

        echo "<td>" . $row['description'] . "</td>";
        $idachievement = $row['idachievement'];
        echo "<td><a class='pagination-btn' href ='achivementedit.php?id=$idachievement'>Edit</td>";
        echo "<td ><a class='pagination-btn' href ='achivementDelete.php?id=$idachievement' onclick='return confirm(\"Apakah Anda yakin ingin menghapus achievement ini?\")'>Hapus</td>";
        echo "</tr>";
    }

    echo "</table>";

    $stmt->close();
    $koneksi->close();
    
?>
<a class='pagination-btn' href="achivementTambah.php">Insert New Achievement</a><br>
<a class='pagination-btn' href="adminhome.php">Back to Home</a>