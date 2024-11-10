<?php
// include '../database.php';
class Achievement {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getAchievements($keyword = '', $start = 0, $perpage = 5) {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT ac.*, t.name as team 
                FROM achievement ac 
                INNER JOIN team t ON ac.idteam = t.idteam 
                WHERE ac.name LIKE ? 
                LIMIT ?, ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $keyword, $start, $perpage);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalAchievements($keyword = '') {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT COUNT(*) as total 
                FROM achievement ac 
                INNER JOIN team t ON ac.idteam = t.idteam 
                WHERE ac.name LIKE ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function deleteAchievement($id) {
        $sql = "DELETE FROM achievement WHERE idachievement = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAchievementById($id) {
        $sql = "SE3LECT ac.*, t.name as team 
                FROM achievement ac 
                INNER JOIN team t ON ac.idteam = t.idteam 
                WHERE ac.idachievement = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    public function updateAchievement($id, $team, $name, $date, $description) {
        $sql = "UPDATE achievement 
                SET idteam = (SELECT idteam FROM team WHERE name = ?), name = ?, date = ?, description = ? 
                WHERE idachievement = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $team, $name, $date, $description, $id);
        return $stmt->execute();
    }

    public function getTeams() {
        $sql = "SELECT * FROM team";
        $result = $this->conn->query($sql);
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createAchievement($team, $name, $date, $description) {
        $sql = "INSERT INTO achievement (idteam, name, date, description) 
                VALUES ((SELECT idteam FROM team WHERE name = ?), ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $team, $name, $date, $description);
        return $stmt->execute();
    }

    public function getPaginationData($currentPage, $perPage, $keyword) {
        $totalAchievements = $this->getTotalAchievements($keyword);
        $totalPages = ceil($totalAchievements / $perPage);
        
        $pagination = [
            'totalAchievements' => $totalAchievements,
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
    public function getPaginationLinks($currentPage, $totalPage, $keyword, $rowsPerPage) {
        $links = "";
        if ($currentPage > 1) {
            $prevPage = $currentPage - 1;
            $links .= "<a class='pagination-btn' href='achievement.php?p=$prevPage&keyword=$keyword&rows=$rowsPerPage'><</a> ";
        }
        $links .= "<a class='pagination-btn' href='achievement.php?p=1&keyword=$keyword&rows=$rowsPerPage'>First</a> ";
        for ($i = 1; $i <= $totalPage; $i++) {
            $links .= "<a class='pagination-btn' href='achievement.php?p=$i&keyword=$keyword&rows=$rowsPerPage'>$i</a> ";
        }
        $links .= "<a class='pagination-btn' href='achievement.php?p=$totalPage&keyword=$keyword&rows=$rowsPerPage'>Last</a> ";
        if ($currentPage < $totalPage) {
            $nextPage = $currentPage + 1;
            $links .= "<a class='pagination-btn' href='achievement.php?p=$nextPage&keyword=$keyword&rows=$rowsPerPage'>></a> ";
        }

        return $links;
    }
}
?>
