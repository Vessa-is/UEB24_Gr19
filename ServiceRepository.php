<?php

class ServiceRepository {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll($order_by = 'name ASC') {
        $sql = "SELECT * FROM sherbimet ORDER BY $order_by";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM sherbimet WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}




?>