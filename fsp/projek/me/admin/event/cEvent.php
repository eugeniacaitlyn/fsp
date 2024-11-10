<?php
class Event
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function getEventById($idevent)
    {
        $sql = "SELECT * FROM event WHERE idevent=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getTeamsInEvent($idevent)
    {
        $sql = "SELECT t.name, evt.idevent, evt.idteam 
                FROM event_teams evt 
                LEFT JOIN team t ON evt.idteam=t.idteam 
                WHERE evt.idevent=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllTeams()
    {
        $sql = "SELECT idteam, name FROM team";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateEvent($idevent, $name, $date, $description)
    {
        $sql = "UPDATE event SET name=?, date=?, description=? WHERE idevent=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $date, $description, $idevent);
        return $stmt->execute();
    }

    public function addTeamToEvent($idevent, $idteam)
    {
        $sql = "INSERT INTO event_teams (idevent, idteam) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idevent, $idteam);
        return $stmt->execute();
    }

    public function deleteTeamFromEvent($idevent, $idteam)
    {
        $sql = "DELETE FROM event_teams WHERE idevent=? AND idteam=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idevent, $idteam);
        return $stmt->execute();
    }

    public function getEvents($keyword = '', $start = 0, $perPage = 5)
    {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT ev.idevent, ev.name, ev.date, GROUP_CONCAT(t.name SEPARATOR ', ') as TEAMS, ev.description 
                FROM event ev
                LEFT JOIN event_teams evt ON evt.idevent = ev.idevent
                LEFT JOIN team t ON t.idteam = evt.idteam
                WHERE ev.name LIKE ?
                GROUP BY ev.name 
                ORDER BY ev.idevent ASC 
                LIMIT ?, ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $keyword, $start, $perPage);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalEvents($keyword = '')
    {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT COUNT(DISTINCT ev.idevent) as total 
                FROM event ev
                LEFT JOIN event_teams evt ON evt.idevent = ev.idevent
                LEFT JOIN team t ON t.idteam = evt.idteam
                WHERE ev.name LIKE ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function addEvent($name, $date, $description)
    {
        $sql = "INSERT INTO event (name, date, description) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $name, $date, $description);
        return $stmt->execute();
    }

    public function deleteEvent($idevent)
    {
        $sql = "DELETE FROM event WHERE idevent = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idevent);
        return $stmt->execute();
    }

    public function getPaginationData($currentPage, $perPage, $keyword)
    {
        $totalEvents = $this->getTotalEvents($keyword);
        $totalPages = ceil($totalEvents / $perPage);

        return [
            'totalEvents' => $totalEvents,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'hasPrev' => $currentPage > 1,
            'hasNext' => $currentPage < $totalPages,
            'prevPage' => $currentPage > 1 ? $currentPage - 1 : null,
            'nextPage' => $currentPage < $totalPages ? $currentPage + 1 : null,
            'firstPage' => 1,
            'lastPage' => $totalPages
        ];
    }

    public function getPaginationLinks($currentPage, $totalPages, $keyword, $rowsPerPage)
    {
        $links = "";
        if ($currentPage > 1) {
            $prevPage = $currentPage - 1;
            $links .= "<a class='pagination-btn' href='event.php?p=$prevPage&keyword=$keyword&rows=$rowsPerPage'><</a> ";
        }
        $links .= "<a class='pagination-btn' href='event.php?p=1&keyword=$keyword&rows=$rowsPerPage'>First</a> ";

        for ($i = 1; $i <= $totalPages; $i++) {
            $links .= "<a class='pagination-btn' href='event.php?p=$i&keyword=$keyword&rows=$rowsPerPage'>$i</a> ";
        }

        $links .= "<a class='pagination-btn' href='event.php?p=$totalPages&keyword=$keyword&rows=$rowsPerPage'>Last</a> ";

        if ($currentPage < $totalPages) {
            $nextPage = $currentPage + 1;
            $links .= "<a class='pagination-btn' href='event.php?p=$nextPage&keyword=$keyword&rows=$rowsPerPage'>></a> ";
        }

        return $links;
    }
}
?>