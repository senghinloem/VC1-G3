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

    public function addStock($stock_name, $quantity, $status)
    {
        try {
            $sql = "INSERT INTO stock_management (stock_name, quantity, status) 
                    VALUES (:stock_name, :quantity, :status)";
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
            $status = $quantity > 0 ? 'in_stock' : 'out_of_stock';
            $sql = "UPDATE stock_management 
                    SET stock_name = :stock_name, 
                        quantity = :quantity,
                        status = :status 
                    WHERE stock_id = :stock_id";
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

    public function searchStock($search_term, $status, $quantity = null, $search_type = 'anywhere')
    {
        try {
            // Determine the LIKE pattern based on the search type for stock name
            switch ($search_type) {
                case 'start':
                    $like_pattern = $search_term . '%';  // Starts with the search term
                    break;
                case 'end':
                    $like_pattern = '%' . $search_term;  // Ends with the search term
                    break;
                case 'anywhere':
                default:
                    $like_pattern = '%' . $search_term . '%';  // Contains the search term anywhere
                    break;
            }

            // Build the base SQL query
            $sql = "SELECT * FROM stock_management WHERE stock_name LIKE :search_term";

            // Add condition for stock status if provided
            if ($status === 'in_stock') {
                $sql .= " AND quantity > 0";
            } elseif ($status === 'out_of_stock') {
                $sql .= " AND quantity = 0";
            }

            // Add condition for exact quantity if provided
            if ($quantity !== null) {
                $sql .= " AND quantity = :quantity";
            }

            $stmt = $this->db->prepare($sql);

            // Bind the search term with the appropriate LIKE pattern
            $stmt->bindValue(':search_term', $like_pattern, PDO::PARAM_STR);

            // Bind the quantity if it is provided
            if ($quantity !== null) {
                $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            }

            // Execute the query
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching stock: " . $e->getMessage());
            return [];
        }
    }
}
