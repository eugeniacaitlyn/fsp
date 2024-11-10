<?php
class cTeam {
    private $db;
    private $conn;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
        $this->conn = $dbConnection->getConnection();
    }

    public function getUserTeamId($idmember) {
        $query = "SELECT t.idteam 
                  FROM team t
                  INNER JOIN team_members tm ON t.idteam = tm.idteam
                  WHERE tm.idmember = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idmember);
        $stmt->execute();
        $result = $stmt->get_result();

        $teamId = null;
        if ($row = $result->fetch_assoc()) {
            $teamId = $row['idteam'];
        }

        $stmt->close();
        return $teamId;
    }

    public function getUserFullName($idmember) {
        $query = "SELECT fname, lname FROM member WHERE idmember = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idmember);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $fullName = null;
        if ($row = $result->fetch_assoc()) {
            $fullName = $row['fname'] . ' ' . $row['lname'];
        }
        
        $stmt->close();
        return $fullName;
    }
    

    public function getTeamMembers($idteam) {
        $query = "SELECT t.name AS team_name, CONCAT(m.fname, ' ', m.lname) AS member_name
                  FROM team t
                  INNER JOIN team_members tm ON t.idteam = tm.idteam
                  INNER JOIN member m ON tm.idmember = m.idmember
                  WHERE t.idteam = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        $result = $stmt->get_result();

        $members = [];
        while ($row = $result->fetch_assoc()) {
            $members[] = $row;
        }

        $stmt->close();
        return $members;
    }

    public function getTeamAchievements($idteam) {
        $query = "SELECT t.name AS team_name, a.name AS achievement_name, a.date AS achievement_date, a.description AS achievement_description
                  FROM team t
                  INNER JOIN achievement a ON t.idteam = a.idteam
                  WHERE t.idteam = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        $result = $stmt->get_result();

        $achievements = [];
        while ($row = $result->fetch_assoc()) {
            $achievements[] = $row;
        }

        $stmt->close();
        return $achievements;
    }

    public function getTeamEvents($idteam) {
        $query = "SELECT t.name AS team_name, e.name AS event_name, e.date AS event_date, e.description AS event_description
                  FROM team t
                  INNER JOIN event_teams et ON t.idteam = et.idteam
                  INNER JOIN event e ON et.idevent = e.idevent
                  WHERE t.idteam = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        $result = $stmt->get_result();

        $events = [];
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }

        $stmt->close();
        return $events;
    }

    public function getPaginatedTeams($keyword = '', $page = 1, $perPage = 5) {
        $offset = ($page - 1) * $perPage;
        $keyword = '%' . $keyword . '%';

        $query = "SELECT t.idteam, t.name AS team_name
                  FROM team t
                  WHERE t.name LIKE ?
                  ORDER BY t.name
                  LIMIT ?, ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sii", $keyword, $offset, $perPage);
        $stmt->execute();
        $result = $stmt->get_result();

        $teams = [];
        while ($row = $result->fetch_assoc()) {
            $teams[] = $row;
        }

        $stmt->close();
        return $teams;
    }

    public function getTotalTeams($keyword = '') {
        $keyword = '%' . $keyword . '%';

        $query = "SELECT COUNT(*) AS total
                  FROM team t
                  WHERE t.name LIKE ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $stmt->close();
        return $row['total'];
    }

    public function getPagination($keyword = '', $currentPage = 1, $perPage = 5) {
        $totalTeams = $this->getTotalTeams($keyword);
        $totalPages = ceil($totalTeams / $perPage);

        return [
            'totalTeams' => $totalTeams,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'hasPrev' => $currentPage > 1,
            'hasNext' => $currentPage < $totalPages,
            'prevPage' => $currentPage > 1 ? $currentPage - 1 : null,
            'nextPage' => $currentPage < $totalPages ? $currentPage + 1 : null
        ];
    }

    public function getPaginationLinks($keyword = '', $currentPage = 1, $perPage = 5) {
        $pagination = $this->getPagination($keyword, $currentPage, $perPage);
        $links = '';

        if ($pagination['hasPrev']) {
            $links .= "<a href='?page={$pagination['prevPage']}&keyword=$keyword&perPage=$perPage'><</a> ";
        }

        for ($i = 1; $i <= $pagination['totalPages']; $i++) {
            $links .= "<a href='?page=$i&keyword=$keyword&perPage=$perPage'>$i</a> ";
        }

        if ($pagination['hasNext']) {
            $links .= "<a href='?page={$pagination['nextPage']}&keyword=$keyword&perPage=$perPage'>></a> ";
        }

        return $links;
    }

    public function getTeamName($idteam) {
        $query = "SELECT name FROM team WHERE idteam = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        $stmt->close();
        return $row['name'] ?? null;
    }
}
?>
