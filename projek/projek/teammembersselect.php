<div class="teammembers-select">
    <?php
        $koneksi = new mysqli("localhost", "root", "", "capstone");
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $idteam = $_GET['id'];
            $sql = "select m.idmember, concat(m.fname, ' ', m.lname) as fullname, m.username
                    from member m inner join team_members tm
                        on m.idmember = tm.idmember inner join team t
                        on t.idteam = tm.idteam inner join game g
                        on g.idgame = t.idgame
                    where t.idteam =?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<table border='1'>
                    <tr>
                        <th>Member ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th colspan = 2 >Action</th>
                    </tr>
                ";
            while($row = $result->fetch_assoc()){
                $idmember = $row['idmember'];
                echo "<tr>";
                echo "<td>".$row['idmember']."</td>";
                echo "<td>".$row['fullname']."</td>";
                echo "<td>".$row['username']."</td>";
                echo "<td><a href ='teammembersdelete_proses.php?id=$idmember'>delete</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        $stmt->close();
        $koneksi->close();
    ?>
    <br>
    <a href="teammembersadd.php?idteam=<?=$idteam?>">Add Members</a>
    <br>
    <a href="adminhome.php">Back to Home</a>
</div>