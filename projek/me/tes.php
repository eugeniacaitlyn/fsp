<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
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

        if ($page>1){
            $prev = $page-1;
            echo "<a class='pagination-btn' href='gameselect.php?p=$prev&keyword=$keyword'><</a> ";
        }
        echo "<a class='pagination-btn' href='gameselect.php?p=1&keyword=$keyword'>First</a> ";
        //TAMPILKAN PAGE
        for($i=1;$i<=$totalpage;$i++){
            echo "<a  class='pagination-btn' href='gameselect.php?p=$i&keyword=$keyword'>$i</a> ";
        }
        
        echo "<a class='pagination-btn' href='gameselect.php?p=$totalpage&keyword=$keyword'>Last</a> ";
        if ($page<$totalpage){
            $next = $page+1;
            echo "<a class='pagination-btn' href='gameselect.php?p=$next&keyword=$keyword'>></a> ";
        }
        echo "<br><br>";

    

    echo "<table border='1' id='table'>
            <tr>
                <th>Id Game</th>
                <th>Game Name</th>
                <th>Description</th>
                <th colspan = 2 >Action</th>
            </tr>
        ";
    while($row = $result->fetch_assoc()){
        $idgame = $row['idgame'];
        echo "<tr>";
        echo "<td>".$row['idgame']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td><a class='pagination-btn' href ='gameedit.php?id=$idgame'>Edit</td>";
        echo "<td><a class='pagination-btn' href ='gamedelete.php?id=$idgame' onclick='return confirm(\"Apakah Anda yakin ingin menghapus game ini?\")'>Hapus</td>";
        echo "</tr>";
    }
    echo "</table>";

    $stmt->close();
    $koneksi->close();
    

    
?>
<br>
<a class='pagination-btn' href="gameinsert.php">Insert New Game</a>
<br>
<a class='pagination-btn' href="adminhome.php">Back to Home</a>