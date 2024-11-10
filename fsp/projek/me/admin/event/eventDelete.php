<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Event</title>
</head>
<body>
    <?php
        require_once 'cEvent.php';

        $dbConnection = new mysqli("localhost", "root", "", "capstone");
        if ($dbConnection->connect_errno) {
            die("Database connection failed: " . $dbConnection->connect_error);
        }

        $event = new Event($dbConnection);

        if (isset($_GET['id'])) {
            $idevent = $_GET['id'];
            if ($event->deleteEvent($idevent)) {
                header("Location: event.php");
                exit;
            } else {
                echo "<p style='color:red;'>Failed to delete the event. Please try again.</p>";
            }
        }

        $dbConnection->close();
    ?>
    <button onclick="confirmDeletion(<?php echo $_GET['id'] ?? 'null'; ?>)">Delete Event</button>
</body>
</html>
