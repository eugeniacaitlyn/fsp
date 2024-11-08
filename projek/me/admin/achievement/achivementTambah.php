<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Event</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">

</head>
<body>
<?php
include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');
?>    

<div class="main">    
<form action="achivementTambahProses.php" method="POST" enctype="multipart/form-data">
        <label for="team">Team :</label>
        <select name="team" id="team">
            <?php
            $koneksi = new mysqli("localhost", "root", "", "capstone");
            if ($koneksi->connect_errno) {
                echo "Koneksi Failed: " . $koneksi->connect_error;
            }         
            $sql = "SELECT * FROM team";
            $stmt = $koneksi->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
            }
            $koneksi->close();
            $stmt->close();
            
            ?>
        </select>
        <br>
            <label for="name">Achievement Name:</label>
            <input type="text" name="name" > <br>

            <label for="date">Achievement Date:</label>
            <input type="date" name="date" > <br>
            
            <label for="description">Description:</label>
            <textarea name="description" rows="5" cols="50" ></textarea><br>
        <br>
        <input type="submit" name="submit" value="submit">
</form>
    </div>
</body>
</html>