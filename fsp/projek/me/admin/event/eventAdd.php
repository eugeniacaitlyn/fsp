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
    ?>
    
    <div class="main">
        <div class="team-insert">
            <form method="POST" enctype="multipart/form-data" action="insertEventProses.php">
                <label for="name">Event Name:</label>
                <input type="text" name="name" > <br>

                <label for="date">Event Date:</label>
                <input type="date" name="date" > <br>

                <label for="description">Description:</label>
                <textarea name="description" rows="5" cols="50" ></textarea><br>

                <input type="submit" name="submit" value="Add Event">
            </form>
        <br>
        </div>
    </div>
    
</body>
</html>