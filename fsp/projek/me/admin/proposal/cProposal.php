<?php
class Proposal {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getPaginationData($currentPage, $perPage, $keyword) {
        $totalProposals = $this->countProposals($keyword);
        $totalPages = ceil($totalProposals / $perPage);
    
        return [
            'totalProposals' => $totalProposals,
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

    public function getProposals($keyword, $start, $limit) {
        $param = "%$keyword%";
        $sql = "SELECT jp.*, CONCAT(m.fname, ' ', m.lname) AS member, t.name AS team 
                FROM join_proposal jp
                INNER JOIN member m ON m.idmember = jp.idmember 
                INNER JOIN team t ON jp.idteam = t.idteam 
                WHERE CONCAT(m.fname, ' ', m.lname) LIKE ? 
                AND jp.status = 'waiting' 
                LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $param, $start, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function countProposals($keyword) {
        $param = "%$keyword%";
        $sql = "SELECT COUNT(*) AS total 
                FROM join_proposal jp
                INNER JOIN member m ON m.idmember = jp.idmember 
                INNER JOIN team t ON jp.idteam = t.idteam 
                WHERE CONCAT(m.fname, ' ', m.lname) LIKE ? 
                AND jp.status = 'waiting'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    public function approveProposal($idJoinProposal, $idTeam, $idMember, $description = 'Player') {
        $this->conn->begin_transaction();
        try {
            //approve proposal yang dipilih admin
            $sqlUpdate = "UPDATE join_proposal SET status = 'approved' WHERE idjoin_proposal = ?";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param('i', $idJoinProposal);
            $stmtUpdate->execute();
    
            //insert member ke dalam tim
            $sqlInsert = "INSERT INTO team_members (idteam, idmember, description) VALUES (?, ?, ?)";
            $stmtInsert = $this->conn->prepare($sqlInsert);
            $stmtInsert->bind_param('iis', $idTeam, $idMember, $description);
            $stmtInsert->execute();
    
            //reject proposal selain yang tadi di-approve
            $sqlRejectOthers = "UPDATE join_proposal SET status = 'rejected' 
                                WHERE idmember = ? AND idjoin_proposal != ?";
            $stmtRejectOthers = $this->conn->prepare($sqlRejectOthers);
            $stmtRejectOthers->bind_param('ii', $idMember, $idJoinProposal);
            $stmtRejectOthers->execute();
    
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }
    

    public function rejectProposal($idJoinProposal) {
        $sql = "UPDATE join_proposal SET status = 'rejected' WHERE idjoin_proposal = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $idJoinProposal);
        return $stmt->execute();
    }
}
?>
