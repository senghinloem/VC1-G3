<?php
class StockModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getStock()
    {
        try {
            $result = $this->db->query("SELECT * FROM stock_management");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching stock: " . $e->getMessage());
            return [];
        }
    }

    public function view_stock($stock_id)
    {
        $stock = $this->getStockById($stock_id);
        return $stock ?: false;
    }

    public function getStockById($stock_id)
    {
        try {
            $result = $this->db->query("SELECT * FROM stock_management");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching stock: " . $e->getMessage());
            return [];
        }
    }

    public function addStock($stock_name)
    {
        $sql = "INSERT INTO stock_management (stock_name) VALUES (:stock_name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateStock($stock_id, $stock_name)
    {
        $sql = "UPDATE stock_management SET stock_name = :stock_name WHERE stock_id = :stock_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
        $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteStock($stock_id)
    {
        $sql = "DELETE FROM stock_management WHERE stock_id = :stock_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
