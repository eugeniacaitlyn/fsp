<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/achievement/cAchievement.php');

$db = new Database();
$dbConnection = $db->getConnection();

$achievement = new Achievement($dbConnection);

if (isset($_GET['id'])) {
    $idachievement = $_GET['id'];
    
    if ($achievement->deleteAchievement($idachievement)) {
        header("Location: /fsp/projek/me/admin/achievement/achievement.php");
        exit();
    } else {
        echo "Failed to delete achievement.";
    }
} else {
    echo "Invalid request: ID not provided.";
}

$dbConnection->close();
?>
