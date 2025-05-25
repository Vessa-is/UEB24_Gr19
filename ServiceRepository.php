<?php

class ServiceRepository {
    private $conn;

     public function __construct(&$conn) {
        $this->conn = &$conn;
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


    public function &getAllByRef($order_by = 'name ASC') {
        try {
            $allowed_columns = ['name', 'price', 'id', 'time'];
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
            
              $services = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $service = array();
            foreach ($row as $key => $value) {
                $service[$key] = $value;
            }
            $services[] = &$service;
        }
        return $services;
    } catch (PDOException $e) {
            error_log("Gabim në getAllByRef: " . $e->getMessage(), 3, "error.log");
            $empty = [];
            return $empty;
        }
    }

    public function &findByIdRef($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM sherbimet WHERE id = ?");
            $stmt->execute([$id]);
            $service = $stmt->fetch(PDO::FETCH_ASSOC);
            return $service;
        } catch (PDOException $e) {
            error_log("Gabim në findByIdRef: " . $e->getMessage(), 3, "error.log");
            $nullVar = null;
            return $nullVar;
        }
    }

    public function updatePriceByRef(&$service_id, &$new_price) {
        try {
            $stmt = $this->conn->prepare("UPDATE sherbimet SET price = ? WHERE id = ?");
            $stmt->execute([$new_price, $service_id]);
            return true;
        } catch (PDOException $e) {
            error_log("Gabim në updatePriceByRef: " . $e->getMessage(), 3, "error.log");
            return false;
        }
    }
}
?>



