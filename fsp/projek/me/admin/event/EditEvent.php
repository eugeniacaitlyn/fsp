<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <style>
    .grid-container {
      display: grid;
      grid-template-columns: auto auto; 
      gap: 20px; 
    }
    .grid-item {
            border: 1px solid #ddd; 
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #D59966;
        }

        .grid-item table {
            min-height: 200px; 
        }
  </style>
</head>
<body>
    <?php
            include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');
        $koneksi = new mysqli("localhost", "root", "", "capstone");

        if ($koneksi->connect_errno) {
            echo "Koneksi Failed: " .$koneksi->connect_error;
        }
       
        $idevent = $_GET['id'];

        $sql = "SELECT * FROM event WHERE idevent=?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $idevent = $row['idevent'];
            $name = $row['name'];
            $date = $row['date'];
            $description = $row['description'];
        }
        else {
            die("Invalid ID Movie");
        }

        $koneksi->close();
    ?>

    <div class="main">
        <form method="POST" action="editEventProses.php">
            <label>Name</label>
            <input type="text" name="name" value="<?=$name?>"> <br>
            
            <label for="date">Event Date:</label>
            <input type="date" name="date" value="<?=$date?>"> <br>

            <label>Description</label>
            <textarea name="description" rows="5" cols="50"><?=$description?></textarea><br>

            <input type="hidden" name="idevent" value="<?=$idevent?>">
            <input type="submit" name="submit" value="Edit"><br><br>
        </form>

        
    </div>
    

    <div class="grid-container">
        <div class="grid-item">
            <h3>Teams in Event</h3>
            <?php
                $koneksi = new mysqli("localhost", "root", "", "capstone");
                if ($koneksi->connect_errno) {
                    echo "Koneksi Failed: " . $koneksi->connect_error;
                } 
                $team = $_GET['id'];

                $sql = "SELECT t.name, evt.idevent, evt.idteam FROM event_teams evt LEFT JOIN team t ON evt.idteam=t.idteam WHERE evt.idevent = ? ";
                $stmt = $koneksi->prepare($sql);
                $stmt->bind_param("i", $team);
                $stmt->execute();
                $result = $stmt->get_result();

                echo "<table>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>               
                    </tr>";

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";

                        $idevent = $row['idevent'];
                        $idteam = $row['idteam'];
                        $current_url = $_SERVER['REQUEST_URI']; 
                        echo "<td><a href='deleteTeamEvent.php?idevent=$idevent&idteam=$idteam&return_url={$current_url}' onclick='return confirm(\"Apakah Anda yakin ingin menambahkan team ini?\")'>Hapus</a></td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No teams in event</td></tr>";
                }
                echo "</table>";

                $stmt->close();
                $koneksi->close();
            ?>
        </div>

        <div class="grid-item">
            <h3>All Teams</h3>
            <?php
                $koneksi = new mysqli("localhost", "root", "", "capstone");
                if ($koneksi->connect_errno) {
                    echo "Koneksi Failed: " . $koneksi->connect_error;
                }

                $sql = "SELECT idteam, name FROM team";
                $stmt = $koneksi->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                echo "<table>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>               
                    </tr>";

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";

                        $idevent = $_GET['id'];
                        $idteam = $row['idteam'];
                        echo "<td><a href='tambahTeamEvent.php?idevent=$idevent&idteam=$idteam&return_url=EditEvent.php?id=$idevent' onclick='return confirm(\"Apakah Anda yakin ingin menambahkan team ini?\")'>Tambahkan</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No teams available</td></tr>";
                }
                echo "</table>";

                $stmt->close();
                $koneksi->close();
            ?>
        </div>
    </div>
</body>
</html>