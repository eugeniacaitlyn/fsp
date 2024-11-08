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
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $idteam = $_GET['id'];
            $sql = "SELECT m.idmember, CONCAT(m.fname, ' ', m.lname) AS fullname, m.username
                    FROM member m 
                    INNER JOIN team_members tm ON m.idmember = tm.idmember
                    INNER JOIN team t ON t.idteam = tm.idteam
                    INNER JOIN game g ON g.idgame = t.idgame
                    WHERE t.idteam = ?";
            $sql2 = "SELECT t.name 
                     FROM team t
                     INNER JOIN team_members tm ON t.idteam = tm.idteam
                     WHERE t.idteam LIKE $idteam
                     GROUP BY t.idteam;";
                     
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $result = $stmt->get_result();

            $stmt2 = $koneksi->prepare($sql2);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            if ($result2->num_rows > 0) {
                $teamname = $result2->fetch_assoc()['name'];
            } else {
                $teamname = " ini tidak ada anggota"; 
            }

            $stmt2->close();
        }

        echo '<div class="main">';
        echo '    <main class="table">';
        echo '        <div class="table__header">';
        echo '            <h1>Team  ' . htmlspecialchars($teamname) . '</h1>';
        echo '            <a href="/fsp/projek/me/admin/team/team.php">';
        echo '                <button class="add-new-button">back';
        echo '                    <i class="bx bx-arrow-back"></i>';
        echo '                </button>';
        echo '            </a>';
        echo '        </div>';
        echo '        <div class="table__body">';
        echo '            <table>';
        echo '                <thead>';
        echo '                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>';
        echo '                </thead>';
        echo '                <tbody>';
        while($row = $result->fetch_assoc()){
            $idmember = $row['idmember'];
            echo "<tr>";
            echo "<td>".$row['idmember']."</td>";
            echo "<td>".$row['fullname']."</td>";
            echo "<td>".$row['username']."</td>";
            echo "<td>
                    <a class='pagination-btn' href ='/fsp/projek/me/admin/member/memberDelete.php?id=$idmember' onclick='return confirm(\"Apakah Anda yakin ingin menghapus team ini?\")'>                        <button class='icon-button trash' >
                            <i class='bx bxs-trash-alt'></i>
                        </button>
                    </a></td>";
        
            echo "</tr>";
        }

        echo '                </tbody>';
        echo '            </table>';
        echo '        </div>';
        echo '    </main>';
        echo '</div>';
        $stmt->close();
        $koneksi->close();
        ?>    
</body>
</html>
