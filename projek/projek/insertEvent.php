<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Event</title>
</head>
<body>
<form method="POST" enctype="multipart/form-data" action="insertEventProses.php">
    <label for="name">Event Name:</label>
    <input type="text" name="name" > <br>

    <label for="date">Event Date:</label>
    <input type="date" name="date" > <br>

    <label for="description">Description:</label>
    <textarea name="description" rows="5" cols="50" ></textarea><br>
    

    <input type="submit" name="submit" value="Add Event">
</form>
</body>
</html>