<?php
class Team
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function getTeams($keyword = '', $start = 0, $perpage = 5)
    {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT t.idteam, t.name AS Team, g.name AS Game,
                    GROUP_CONCAT(DISTINCT ev.name SEPARATOR ', ') AS Events,
                    GROUP_CONCAT(DISTINCT CONCAT(ach.name, ' ', ach.description) SEPARATOR ', ') AS Achievement,
                    COUNT(tm.idmember) AS member_count
                FROM team t 
                LEFT JOIN game g ON t.idgame = g.idgame 
                LEFT JOIN event_teams evt ON t.idteam = evt.idteam 
                LEFT JOIN event ev ON ev.idevent = evt.idevent  
                LEFT JOIN achievement ach ON t.idTeam = ach.idteam
                LEFT JOIN team_members tm ON t.idteam = tm.idteam
                WHERE t.name LIKE ? 
                GROUP BY t.idteam
                ORDER BY t.idteam ASC 
                LIMIT ?, ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $keyword, $start, $perpage);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTeamById($id)
    {
        $sql = "SELECT t.idteam, t.name
                FROM team t
                WHERE t.idteam = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function getTotalTeams($keyword = '')
    {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT COUNT(*) AS total 
                FROM team t 
                WHERE t.name LIKE ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function getPaginationData($currentPage, $perPage, $keyword)
    {
        $totalTeams = $this->getTotalTeams($keyword);
        $totalPages = ceil($totalTeams / $perPage);

        $pagination = [
            'totalTeams' => $totalTeams,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'hasPrev' => $currentPage > 1,
            'hasNext' => $currentPage < $totalPages,
            'prevPage' => $currentPage > 1 ? $currentPage - 1 : null,
            'nextPage' => $currentPage < $totalPages ? $currentPage + 1 : null,
            'firstPage' => 1,
            'lastPage' => $totalPages
        ];

        return $pagination;
    }

    public function getPaginationLinks($currentPage, $totalPage, $keyword, $rowsPerPage)
    {
        $links = "";
        if ($currentPage > 1) {
            $prevPage = $currentPage - 1;
            $links .= "<a class='pagination-btn' href='team.php?p=$prevPage&keyword=$keyword&rows=$rowsPerPage'><</a> ";
        }
        $links .= "<a class='pagination-btn' href='team.php?p=1&keyword=$keyword&rows=$rowsPerPage'>First</a> ";
        for ($i = 1; $i <= $totalPage; $i++) {
            $links .= "<a class='pagination-btn' href='team.php?p=$i&keyword=$keyword&rows=$rowsPerPage'>$i</a> ";
        }
        $links .= "<a class='pagination-btn' href='team.php?p=$totalPage&keyword=$keyword&rows=$rowsPerPage'>Last</a> ";
        if ($currentPage < $totalPage) {
            $nextPage = $currentPage + 1;
            $links .= "<a class='pagination-btn' href='team.php?p=$nextPage&keyword=$keyword&rows=$rowsPerPage'>></a> ";
        }

        return $links;
    }

    public function getTeamsForDropdown()
    {
        $sql = "SELECT idteam, name FROM team";
        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createTeam($game, $teamName)
    {
        $sql = "INSERT INTO team (idgame, name) VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $game, $teamName);
        return $stmt->execute();
    }

    public function deleteTeam($id)
    {
        $sql = "DELETE FROM team WHERE idteam = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function updateTeam($id, $game, $teamName)
    {
        $sql = "UPDATE team SET idgame = ?, name = ? WHERE idteam = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isi", $game, $teamName, $id);
        return $stmt->execute();
    }

    public function getGames()
    {
        $sql = "SELECT idgame, name FROM game";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTeamMembers($teamId)
    {
        $sql = "SELECT m.idmember, CONCAT(m.fname, ' ', m.lname) AS fullname, m.username
                FROM member m
                INNER JOIN team_members tm ON m.idmember = tm.idmember
                WHERE tm.idteam = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $teamId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function removeMemberFromTeam($idmember)
    {
        $sql = "DELETE FROM team_members WHERE idmember = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idmember);

        return $stmt->execute();
    }
}
?>