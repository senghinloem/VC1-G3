<?php
class StockModel
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new Database("localhost", "vc1_db", "root", "");
        } catch (PDOException $e) {
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

    public function getStockById($stock_id)
    {
        try {
            $sql = "SELECT sm.*, p.product_id, p.image, p.name, p.description, p.price, p.unit, sm.quantity AS stock_quantity 
                    FROM stock_management sm 
                    LEFT JOIN products p ON sm.product_id = p.product_id 
                    WHERE sm.stock_id = :stock_id";
            $result = $this->db->query($sql, ["stock_id" => $stock_id]);
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching stock by ID: " . $e->getMessage());
            return false;
        }
    }

    public function addStock($stock_name, $quantity)
    {
        try {
            $sql = "INSERT INTO stock_management (stock_name, quantity, stock_type, status) 
                    VALUES (:stock_name, :quantity, 'IN', :status)";
            $status = $quantity > 0 ? 'in_stock' : 'out_of_stock';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error adding stock: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateStock($stock_id, $stock_name, $quantity)
    {
        try {
            $sql = "UPDATE stock_management 
                    SET stock_name = :stock_name, 
                        quantity = :quantity,
                        status = :status
                    WHERE stock_id = :stock_id";
            $status = $quantity > 0 ? 'in_stock' : 'out_of_stock';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
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
            $success = $stmt->execute();

            if (!$success || $stmt->rowCount() === 0) {
                error_log("No stock item found with ID: " . $stock_id);
                return false;
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting stock: " . $e->getMessage());
            return false;
        }
    }

    public function searchStock($search_term)
    {
        try {
            $sql = "SELECT * FROM stock_management WHERE stock_name LIKE :search_term";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search_term', '%' . $search_term . '%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching stock: " . $e->getMessage());
            return [];
        }
    }
}