<?php
include_once('/projek/me/database.php');
class Achievement {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Get achievements with optional keyword search, pagination supported
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

    // Get total count of achievements with optional keyword search
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

    // Delete an achievement by ID
    public function deleteAchievement($id) {
        $sql = "DELETE FROM achievement WHERE idachievement = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Get a single achievement by ID
    public function getAchievementById($id) {
        $sql = "SELECT ac.*, t.name as team 
                FROM achievement ac 
                INNER JOIN team t ON ac.idteam = t.idteam 
                WHERE ac.idachievement = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    // Update an achievement by ID
    public function updateAchievement($id, $team, $name, $date, $description) {
        $sql = "UPDATE achievement 
                SET idteam = (SELECT idteam FROM team WHERE name = ?), name = ?, date = ?, description = ? 
                WHERE idachievement = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssi", $team, $name, $date, $description, $id);
        return $stmt->execute();
    }

    // Get a list of all teams
    public function getTeams() {
        $sql = "SELECT * FROM team";
        $result = $this->conn->query($sql);
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Insert a new achievement
    public function createAchievement($team, $name, $date, $description) {
        $sql = "INSERT INTO achievement (idteam, name, date, description) 
                VALUES ((SELECT idteam FROM team WHERE name = ?), ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $team, $name, $date, $description);
        return $stmt->execute();
    }
}
?>
