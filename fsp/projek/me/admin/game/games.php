<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php')
    ?>
    <div class="main">
    <main class="table">
        <div class="table__header">
            <h1>Games</h1>
            <div class="search-container">
                <div class="input-box">
                    <input type="text" name="keyword" placeholder="Search data">
                    <i class='bx bx-search'></i>
                </div>
                <button type='submit' name='submit' value='Search'>Search </button>
            </div>
            <a href="/fsp/projek/me/admin/game/gameAdd.php">
                <button class="add-new-button">Add game
                    <i class='bx bx-plus'></i>
                </button>
            </a>
        </div>
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Game</th>
                        <th>Desc</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> 1 </td>
                        <td> game 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt' href ='eventDelete.php?id=$idevent' onclick='return confirm("Apakah Anda yakin ingin menghapus event ini?")'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td> 1 </td>
                        <td> game 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt' href ='eventDelete.php?id=$idevent' onclick='return confirm("Apakah Anda yakin ingin menghapus event ini?")'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td> 1 </td>
                        <td> game 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt' href ='eventDelete.php?id=$idevent' onclick='return confirm("Apakah Anda yakin ingin menghapus event ini?")'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td> 1 </td>
                        <td> game 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt' href ='eventDelete.php?id=$idevent' onclick='return confirm("Apakah Anda yakin ingin menghapus event ini?")'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td> 1 </td>
                        <td> game 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt' href ='eventDelete.php?id=$idevent' onclick='return confirm("Apakah Anda yakin ingin menghapus event ini?")'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td> 1 </td>
                        <td> game 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt' href ='eventDelete.php?id=$idevent' onclick='return confirm("Apakah Anda yakin ingin menghapus event ini?")'></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td> 1 </td>
                        <td> game 1 </td>
                        <td> lorem ipsum dolar sia najenfieufa eifo jaewo faoiew fi aefa eaf ew </td>
                        <td>
                            <button class="icon-button edit">
                                <i class='bx bxs-edit-alt'></i>
                            </button>
                            <button class="icon-button trash">
                                <i class='bx bxs-trash-alt' href ='eventDelete.php?id=$idevent' onclick='return confirm("Apakah Anda yakin ingin menghapus event ini?")'></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination-container">
            <label for="rows">Rows per page: </label>
            <select name="rows" id="rows">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </main>
    </div>
</body>
</html>



awjigojreoiajeroigja oerijg aerg 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');
        $koneksi = new mysqli("localhost", "root", "", "capstone");

        $keyword = "";
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
        }
    ?>
    <div class="main">
    <main class="table">
        <div class="table__header">
            <h1>Games</h1>
            <form method="get" action="">
            <div class="search-container">
                <div class="input-box">
                    <input type="text" name="keyword" placeholder="Search data">
                    <i class='bx bx-search'></i>
                </div>
                <button type='submit' name='submit' value='Search'>Search </button>
            </div>
            <a href="/fsp/projek/me/admin/game/gameAdd.php">
                <button class="add-new-button">Add games
                    <i class='bx bx-plus'></i>
                </button>
            </a>
            </form>
            <?php
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
            ?>
        </div>
        
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Game</th>
                        <th>Team</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $result->fetch_assoc()){
                            $idgame = $row['idgame'];
                            echo "<tr>";
                            echo "<td>".$row['idgame']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['description']."</td>";
                            echo "<td><a class='pagination-btn' href ='gameedit.php?id=$idgame'>Edit</td>";
                            echo "<td><a class='pagination-btn' href ='gameDelete.php?id=$idgame' onclick='return confirm(\"Apakah Anda yakin ingin menghapus game ini?\")'>Hapus</td>";
                            echo "</tr>";
                        }
                        $stmt->close();
                        $koneksi->close();
                    ?>
                </tbody>
            </table>
        </div>
        <form>
        <div class="pagination-container">
            <label for="rows">Rows per page: </label>
            <select name="rows" id="rows">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>

            <?php
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
            ?>
        </div>
        </form>
    </main>
    </div>
</body>
</html>