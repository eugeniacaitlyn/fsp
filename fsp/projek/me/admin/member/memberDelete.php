<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/database.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/fsp/projek/me/admin/team/cTeam.php');

    $db = new Database();
    $dbConnection = $db->getConnection();
    $teamClass = new Team($dbConnection);

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $idmember = $_GET['id'];

        if ($teamClass->removeMemberFromTeam($idmember)) {
            echo "<script>
                    alert('Member deleted successfully.');
                    window.location.href = '/fsp/projek/me/admin/team/team.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to delete the member.');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Invalid member ID.');
                window.location.href = '/fsp/projek/me/admin/team/team.php';
              </script>";
    }

    $dbConnection->close();
?>
