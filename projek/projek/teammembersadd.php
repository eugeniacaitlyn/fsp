<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Members</title>
</head>
<body>
    <div class="teammembers-add">
        <?php
            $koneksi = new mysqli("localhost", "root", "", "capstone");

            if (isset($_GET['idteam']) && is_numeric($_GET['idteam'])) {
                $idteam = $_GET['idteam'];

                // $sql = "SELECT * FROM team_members tm
                //         INNER JOIN member m ON m.idmember = tm.idmember
                //         WHERE tm.idteam = ?";
                
                // $stmt = $koneksi->prepare($sql);
                // $stmt->bind_param("i", $idteam);
                // $stmt->execute();
                // $result = $stmt->get_result();

                $sql2 = "select jp.idjoin_proposal as idjoin_proposal, jp.idteam as idteam, jp.idmember as idmember, concat(m.fname, ' ', m.lname) as name, jp.description as description
                        from join_proposal jp inner join member m
                            on jp.idmember = m.idmember inner join team t
                            on t.idteam = jp.idteam
                        where jp.status = 'waiting' && jp.idteam = ?";

                echo "Team ID: ".$idteam."<br>";
                echo "<label>Join Proposals:</label><br>";

                $stmt = $koneksi->prepare($sql2);
                $stmt->bind_param("i", $idteam);
                $stmt->execute();
                $result2 = $stmt->get_result();

                if ($result2->num_rows > 0) {
                    echo "<table border='1'>
                            <tr>
                                <th>Id Join Proposal</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th colspan = 2>Actions</th>
                            </tr>";

                    while ($row = $result2->fetch_assoc()) {
                        $idmember = $row['idmember'];
                        $idjoin_proposal = $row['idjoin_proposal'];
                        $description = $row['description'];

                        echo "<tr>";
                        echo "<td>" . $row['idjoin_proposal'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        
                        //approved
                        echo "<td>
                                <form method='POST' action='teammembersadd_proses.php'>
                                    <input type='hidden' name='idteam' value='" . $idteam . "'>
                                    <input type='hidden' name='idmember' value='" . $idmember . "'>
                                    <input type='hidden' name='idjoin_proposal' value='" . $idjoin_proposal . "'>
                                    <input type='hidden' name='description' value='" . $description . "'>
                                    <button type='submit' name='submit' value='Add to Team'>Add to Team</button>
                                </form>
                            </td>";
                        
                        //rejected
                        echo "<td>
                                <form method='POST' action='teammembersreject_proses.php'>
                                    <input type='hidden' name='idteam' value='" . $idteam . "'>
                                    <input type='hidden' name='idmember' value='" . $idmember . "'>
                                    <input type='hidden' name='idjoin_proposal' value='" . $idjoin_proposal . "'>
                                    <input type='hidden' name='description' value='" . $description . "'>
                                    <button type='submit' name='submit' value='Reject'>Reject</button>
                                </form>
                            </td>";
                        
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No join proposals available.";
                }

            } else {
                echo "Invalid Team ID.";
            }

            $stmt->close();
            $koneksi->close();
        ?>

        <br>
        <a href="teamselect.php">Back to All Teams</a>
    </div>
</body>
</html>