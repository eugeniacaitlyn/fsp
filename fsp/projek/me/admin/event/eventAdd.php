<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="/fsp/projek/me/css/bodyAdmin.css">
</head>
<body>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/aside.php');
        require_once 'cEvent.php';

        $dbConnection = new mysqli("localhost", "root", "", "capstone");
        if ($dbConnection->connect_errno) {
            die("Database connection failed: " . $dbConnection->connect_error);
        }

        $event = new Event($dbConnection);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $name = $_POST['name'];
            $date = $_POST['date'];
            $description = $_POST['description'];

            if ($event->addEvent($name, $date, $description)) {
                header("Location: event.php"); // Redirect to the event list
                exit;
            } else {
                echo "<p style='color:red;'>Failed to add event. Please try again.</p>";
            }
        }
    ?>

    <div class="main">
        <div class="team-insert">
            <form method="POST" enctype="multipart/form-data">
                <label for="name">Event Name:</label>
                <input type="text" name="name" required> <br>

                <label for="date">Event Date:</label>
                <input type="date" name="date" required> <br>

                <label for="description">Description:</label>
                <textarea name="description" rows="5" cols="50" required></textarea><br>

                <input type="submit" name="submit" value="Add Event">
            </form>
            <br>
        </div>
    </div>
</body>
</html>
