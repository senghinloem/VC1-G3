<?php
class StockModel
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new Database("localhost", "vc1_db", "root", "");
        } catch (PDOException $e) {
            // Log the error and handle it gracefully
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Failed to connect to database");
        }
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
            $result = $this->db->query(
                "SELECT * FROM stock_management WHERE stock_id = :stock_id", 
                ["stock_id" => $stock_id]
            );
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching stock by ID: " . $e->getMessage());
            return false;
        }
    }

    public function addStock($stock_name, $status)
    {
        try {
            // Assuming the table might have different column names
            // Adjust these based on your actual table structure
            $sql = "INSERT INTO stock_management (name, last_updated) VALUES (:name, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $stock_name, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error adding stock: " . $e->getMessage());
            return false;
        }
    }

    public function updateStock($stock_id, $stock_name)
    {
        try {
            $sql = "UPDATE stock_management SET name = :name, last_updated = NOW() WHERE stock_id = :stock_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $stock_name, PDO::PARAM_STR);
            $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating stock: " . $e->getMessage());
            return false;
        }
    }

    public function deleteStock($stock_id)
    {
        try {
            $sql = "DELETE FROM stock_management WHERE stock_id = :stock_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting stock: " . $e->getMessage());
            return false;
        }
    }
}
?>