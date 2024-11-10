<?php
class Game {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getGames($keyword = '', $start = 0, $perpage = 5) {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT * FROM game WHERE name LIKE ? LIMIT ?, ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $keyword, $start, $perpage);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalGames($keyword = '') {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT COUNT(*) as total FROM game WHERE name LIKE ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function deleteGame($id) {
        $sql = "DELETE FROM game WHERE idgame = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getGameById($id) {
        $sql = "SELECT * FROM game WHERE idgame = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    public function updateGame($id, $name, $description) {
        $sql = "UPDATE game SET name = ?, description = ? WHERE idgame = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $description, $id);
        return $stmt->execute();
    }

    public function createGame($name, $description) {
        $sql = "INSERT INTO game (name, description) VALUES (?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $name, $description);
        return $stmt->execute();
    }

    public function getPaginationData($currentPage, $perPage, $keyword) {
        $totalGames = $this->getTotalGames($keyword);
        $totalPages = ceil($totalGames / $perPage);
        
        $pagination = [
            'totalGames' => $totalGames,
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
            $links .= "<a class='pagination-btn' href='game.php?p=$prevPage&keyword=$keyword&rows=$rowsPerPage'><</a> ";
        }
        $links .= "<a class='pagination-btn' href='game.php?p=1&keyword=$keyword&rows=$rowsPerPage'>First</a> ";
        for ($i = 1; $i <= $totalPage; $i++) {
            $links .= "<a class='pagination-btn' href='game.php?p=$i&keyword=$keyword&rows=$rowsPerPage'>$i</a> ";
        }
        $links .= "<a class='pagination-btn' href='game.php?p=$totalPage&keyword=$keyword&rows=$rowsPerPage'>Last</a> ";
        if ($currentPage < $totalPage) {
            $nextPage = $currentPage + 1;
            $links .= "<a class='pagination-btn' href='game.php?p=$nextPage&keyword=$keyword&rows=$rowsPerPage'>></a> ";
        }

        return $links;
    }
}
?>