<?php
class Proposal
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    // Fetch all teams
    public function fetchTeams()
    {
        $query = "SELECT idteam, name FROM team";
        return mysqli_query($this->conn, $query);
    }

    public function isUserInTeam($idmember) {
        $query = "SELECT t.name FROM team t 
                  INNER JOIN team_members tm ON tm.idteam = t.idteam
                  WHERE tm.idmember = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idmember);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $team = $result->fetch_assoc();
            return $team['name'];
        }
        return false;
    }    

    public function submitProposal($idmember, $idteam, $description)
    {
        $teamName = $this->isUserInTeam($idmember);
        if ($teamName) {
            return "You are already part of a team: $teamName";
        }

        $description = mysqli_real_escape_string($this->conn, $description);
        $query = "INSERT INTO join_proposal (idmember, idteam, description) VALUES ('$idmember', '$idteam', '$description')";

        if (mysqli_query($this->conn, $query)) {
            return true;
        } else {
            return "Failed to submit join proposal. Please try again.";
        }
    }

    public function getUserDetails($username)
    {
        $query = "SELECT CONCAT(fname, ' ', lname) AS name, idmember FROM member WHERE username = '$username'";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }

    public function searchProposals($idmember, $keyword = "")
    {
        if ($keyword == "") {
            $query = "
                SELECT t.name AS Team, jp.description AS Description, jp.status AS Status
                FROM team t
                INNER JOIN join_proposal jp ON t.idteam = jp.idteam
                WHERE jp.idmember = '$idmember'
            ";
            $stmt = $this->conn->prepare($query);
        } else {
            $param = "%$keyword%";
            $query = "
                SELECT t.name AS Team, jp.description AS Description, jp.status AS Status
                FROM team t
                INNER JOIN join_proposal jp ON t.idteam = jp.idteam
                WHERE jp.idmember = '$idmember'
                AND (jp.description LIKE ? OR t.name LIKE ? OR jp.status LIKE ?)
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sss", $param, $param, $param);
        }

        $stmt->execute();
        return $stmt->get_result();
    }
}

?>