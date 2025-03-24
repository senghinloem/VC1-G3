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
            // Fetch stock ordered by stock_id in descending order
            $result = $this->db->query("SELECT * FROM stock_management ORDER BY stock_id DESC");
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

    public function addStock($stock_name, $status)
    {
        $sql = "INSERT INTO stock_management (stock_name, status) VALUES (:stock_name, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);  // Binding the status value
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

    public function searchStockByName($stock_name)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM stock_management WHERE stock_name LIKE :stock_name");
            $searchTerm = "%" . $stock_name . "%";
            $stmt->bindParam(':stock_name', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching stock by name: " . $e->getMessage());
            return [];
        }
    }

    // New: Filter products by stock status (In Stock / Out of Stock)
    public function searchByStockStatus($status)
    {
        try {
            $query = $status === 'in_stock' ? "SELECT * FROM stock_management WHERE quantity > 0" : "SELECT * FROM stock_management WHERE quantity = 0";
            $result = $this->db->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error filtering stock by status: " . $e->getMessage());
            return [];
        }
    }
}
