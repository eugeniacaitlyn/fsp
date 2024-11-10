<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/database.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/fsp/projek/me/admin/proposal/cProposal.php');

$koneksi = new Database();
$dbConnection = $koneksi->getConnection();

if (isset($_POST['submit'])) {
    $idJoinProposal = $_POST["idjoin_proposal"];

    $proposal = new Proposal($dbConnection);
    $success = $proposal->rejectProposal($idJoinProposal);

    if ($success) {
        echo "<script>
                alert('Proposal rejected successfully.');
                window.location.href = '/fsp/projek/me/admin/proposal/proposal.php';
              </script>";
    } else {
        echo "<script>
                alert('Failed to reject the proposal. Please try again.');
                window.location.href = '/fsp/projek/me/admin/proposal/proposal.php';
              </script>";
    }
} else {
    echo "<script>
            alert('No data submitted. Please try again.');
            window.location.href = '/fsp/projek/me/admin/proposal/proposal.php';
          </script>";
}

$dbConnection->close();
?>
