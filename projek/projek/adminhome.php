<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
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
    </style>
</head>
<body>
    <div class="admin-home">
        <h2 >WELCOME (ADMIN NAME HERE)</h2>
        <form method='POST' action='gameselect.php'>
            <button type='submit' name='btnGames' value='Game' class="pagination-btn">Games</button>
        </form>
        <form method='POST' action='teamselect.php'>
            <button type='submit' name='btnTeams' value='Team' class="pagination-btn">Teams</button>
        </form>
        <form method='POST' action='event.php'>
            <button type='submit' name='btnEvents' value='Event' class="pagination-btn">Events</button>
        </form>
        <form method='POST' action='achivement.php'>
            <button type='submit' name='btnAchievements' value='Achievement' class="pagination-btn">Achievements</button>
        </form>
    </div>
</body>
</html>