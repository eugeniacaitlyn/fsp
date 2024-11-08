<?php
$koneksi = new mysqli("localhost", "root", "", "capstone");

if ($koneksi->connect_errno) {
    echo "Koneksi Failed: " . $koneksi->connect_error;
}

$idteam = $_GET['id'];

$check_sql = "SELECT 
                (SELECT COUNT(*) FROM achievement WHERE idteam = ?) AS achievement_count, 
                (SELECT COUNT(*) FROM event_teams WHERE idteam = ?) AS event_count";
$check_stmt = $koneksi->prepare($check_sql);

if ($check_stmt === false) {
    die("Error preparing query: " . $koneksi->error);
}

$check_stmt->bind_param("ii", $idteam, $idteam);
$check_stmt->execute();
$check_stmt->bind_result($achievement_count, $event_count);
$check_stmt->fetch();
$check_stmt->close();

if ($achievement_count > 0 || $event_count > 0) {
    echo "<script>
        alert('Cannot delete team because it has achievements or is part of events.');
        window.location.href = '/fsp/projek/me/admin/team/team.php';
    </script>";
} else {
    $sql = "DELETE FROM team WHERE idteam = ?";
    $stmt = $koneksi->prepare($sql);

    if ($stmt === false) {
        die("Error preparing delete query: " . $koneksi->error);
    }

    $stmt->bind_param("i", $idteam);
    $stmt->execute();
    
    header("Location: /fsp/projek/me/admin/team/team.php");
}
$koneksi->close();
?>
