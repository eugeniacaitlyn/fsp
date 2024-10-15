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
    <div class="team-insert">
            <form method="POST" enctype="multipart/form-data" action="insertEventProses.php">
                <label for="name">Event Name:</label>
            </form>
        <br>
        <a href="/fsp/projek/me/admin/achievement/achievement.php">Back to Home</a>
    </div>
</body>
</html>