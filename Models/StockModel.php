<?php
class StockModel
{
    private $db;

    public function __construct()
    {
        try {
            // Only initialize the database once
            $this->db = new Database("localhost", "vc1_db", "root", "");
        } catch (PDOException $e) {
            die("Could not connect to the database: " . $e->getMessage());
        }
    }

    // Get all stock items
    public function getStock()
    {
        $result = $this->db->query("SELECT * FROM stock_management");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }



    // Get a specific stock item by ID
    public function getStockById($stock_id)
    {
        $result = $this->db->query("SELECT * FROM stock_management WHERE stock_id = :stock_id", ["stock_id" => $stock_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new stock item
    public function addStock($stock_name)
    {
        $sql = "INSERT INTO stock_management (stock_name, last_updated) VALUES (:stock_name, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Update an existing stock item
    public function updateStock($stock_id, $stock_name)
    {
        $sql = "UPDATE stock_management SET stock_name = :stock_name, last_updated = NOW() WHERE stock_id = :stock_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
        $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Delete a stock item
    public function deleteStock($stock_id)
    {
        $sql = "DELETE FROM stock_management WHERE stock_id = :stock_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
