<?php

class ServiceRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll($order_by = 'name ASC') {
        try {
           
            $allowed_columns = ['name', 'price', 'id'];
            $allowed_directions = ['ASC', 'DESC'];

            $parts = explode(' ', $order_by);
            $column = $parts[0];
            $direction = isset($parts[1]) ? strtoupper($parts[1]) : 'ASC';

            if (!in_array($column, $allowed_columns)) {
                $column = 'name';
            }

            if (!in_array($direction, $allowed_directions)) {
                $direction = 'ASC';
            }

            $sql = "SELECT * FROM sherbimet ORDER BY $column $direction";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Gabim në getAll: " . $e->getMessage();
            return [];
        }
    }

    public function findById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM sherbimet WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Gabim në findById: " . $e->getMessage();
            return null;
        }
    }
}

?>
