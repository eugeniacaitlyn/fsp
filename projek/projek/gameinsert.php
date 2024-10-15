<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Game</title>
</head>
<body>
    <div class="game-insert">
        <form method="POST" enctype="multipart/form-data" action="gameinsert_proses.php">
            <label>Game Name:</label><br>
            <input type="text" name="gamename"></input><br>
            <label>Description: </label><br>
            <textarea name="gamedesc"></textarea><br><br>
            <input type="submit" name="submit" value="Add Game"><br><br>
        </form>
        <br>
        <a href="adminhome.php">Back to Home</a>
    </div>
</body>
</html>