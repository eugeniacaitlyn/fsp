<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Event</title>
</head>

<body>
    <?php
    $koneksi = new mysqli("localhost", "root", "", "capstone");

    if ($koneksi->connect_errno) {
        echo "Koneksi Failed: " . $koneksi->connect_error;
    }

    $idevent = $_GET['idevent'];
    $idteam = $_GET['idteam'];
    $return_url = $_GET['return_url'];

    $sql = "DELETE FROM event_teams WHERE idevent=? and idteam=?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ii", $idevent, $idteam);
    $stmt->execute();
    $koneksi->close();
    header("Location: $return_url");
    exit();
    ?>

</body>

</html>