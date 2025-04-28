
<?php
class StockModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new Database("localhost", "vc1_db", "root", "");
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Failed to connect to database");
        }
    }

    public function getStock() {
        try {
            $sql = "SELECT sm.*, p.name as product_name, p.image as product_image 
                    FROM stock_management sm
                    LEFT JOIN products p ON sm.product_id = p.product_id
                    ORDER BY sm.stock_id DESC";
            $result = $this->db->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching stock: " . $e->getMessage());
            return [];
        }
    }

    public function getStockById($stock_id) {
        try {
            $sql = "SELECT sm.*, p.product_id, p.image, p.name, p.description, p.price, p.unit, sm.quantity AS stock_quantity 
                    FROM stock_management sm 
                    LEFT JOIN products p ON sm.product_id = p.product_id 
                    WHERE sm.stock_id = :stock_id";
            $result = $this->db->query($sql, ["stock_id" => $stock_id]);
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching stock by ID $stock_id: " . $e->getMessage());
            return false;
        }
    }

    public function getProducts() {
        try {
            $sql = "SELECT product_id, name FROM products ORDER BY name ASC";
            $result = $this->db->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching products: " . $e->getMessage());
            return [];
        }
    }

    public function validateProductId($product_id) {
        try {
            $sql = "SELECT COUNT(*) FROM products WHERE product_id = :product_id";
            $result = $this->db->query($sql, ["product_id" => $product_id]);
            return $result->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error validating product ID $product_id: " . $e->getMessage());
            return false;
        }
    }

    public function validateStockId($stock_id) {
        try {
            $sql = "SELECT COUNT(*) FROM stock_management WHERE stock_id = :stock_id";
            $result = $this->db->query($sql, ["stock_id" => $stock_id]);
            return $result->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error validating stock ID $stock_id: " . $e->getMessage());
            return false;
        }
    }

    public function addStock($stock_name, $product_id, $quantity, $user_id) {
        try {
            if (!$this->validateProductId($product_id)) {
                error_log("Invalid product ID: $product_id");
                return false;
            }

            $this->db->beginTransaction();

            // Insert into stock_management
            $sql = "INSERT INTO stock_management (stock_name, product_id, user_id, quantity, stock_type, status) 
                    VALUES (:stock_name, :product_id, :user_id, :quantity, 'IN', :status)";
            $status = $quantity > 0 ? 'in_stock' : 'out_of_stock';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
            // Update or insert into has_stock
            $sql = "INSERT INTO has_stock (product_id, available_quantity) 
                    VALUES (:product_id, :quantity) 
                    ON DUPLICATE KEY UPDATE available_quantity = available_quantity + :quantity";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error adding stock: " . $e->getMessage());
            return false;
        }
    }

    public function updateStock($stock_id, $stock_name, $product_id, $quantity) {
        try {
            if (!$this->validateStockId($stock_id)) {
                error_log("Stock ID does not exist: $stock_id");
                return false;
            }
            if (!$this->validateProductId($product_id)) {
                error_log("Invalid product ID: $product_id for stock_id: $stock_id");
                return false;
            }

            $this->db->beginTransaction();

            // Get current stock data
            $current_stock = $this->getStockById($stock_id);
            if (!$current_stock) {
                $this->db->rollBack();
                error_log("Stock ID $stock_id not found");
                return false;
            }

            $old_product_id = $current_stock['product_id'];
            $old_quantity = $current_stock['stock_quantity'];

            // Update stock_management
            $sql = "UPDATE stock_management 
                    SET stock_name = :stock_name, 
                        product_id = :product_id,
                        quantity = :quantity,
                        status = :status
                    WHERE stock_id = :stock_id";
            $status = $quantity > 0 ? 'in_stock' : 'out_of_stock';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
            $stmt->execute();

            // Update has_stock for old product (if product_id changed)
            if ($old_product_id != $product_id) {
                // Decrease old product's quantity
                $sql = "UPDATE has_stock 
                        SET available_quantity = GREATEST(0, available_quantity - :old_quantity) 
                        WHERE product_id = :old_product_id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':old_quantity', $old_quantity, PDO::PARAM_INT);
                $stmt->bindParam(':old_product_id', $old_product_id, PDO::PARAM_INT);
                $stmt->execute();
                // Insert or update new product's quantity
                $sql = "INSERT INTO has_stock (product_id, available_quantity) 
                        VALUES (:product_id, :quantity) 
                        ON DUPLICATE KEY UPDATE available_quantity = available_quantity + :quantity";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                // Same product, update quantity difference
                $quantity_diff = $quantity - $old_quantity;
                $sql = "UPDATE has_stock 
                        SET available_quantity = GREATEST(0, available_quantity + :quantity_diff) 
                        WHERE product_id = :product_id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':quantity_diff', $quantity_diff, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error updating stock for stock_id: $stock_id - " . $e->getMessage());
            return false;
        }
    }

    public function deleteStock($stock_id) {
        try {
            if (!$this->validateStockId($stock_id)) {
                error_log("Stock ID does not exist: $stock_id");
                return false;
            }

            $this->db->beginTransaction();

            // Get current stock data
            $stock = $this->getStockById($stock_id);
            if (!$stock) {
                $this->db->rollBack();
                error_log("Stock ID $stock_id not found");
                return false;
            }

            // Decrease has_stock quantity
            $sql = "UPDATE has_stock 
                    SET available_quantity = GREATEST(0, available_quantity - :quantity) 
                    WHERE product_id = :product_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':quantity', $stock['stock_quantity'], PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $stock['product_id'], PDO::PARAM_INT);
            $stmt->execute();

            // Delete from stock_management
            $sql = "DELETE FROM stock_management WHERE stock_id = :stock_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error deleting stock: " . $e->getMessage());
            return false;
        }
    }

    public function searchStock($search_term) {
        try {
            $sql = "SELECT sm.*, p.name as product_name, p.image as product_image 
                    FROM stock_management sm
                    LEFT JOIN products p ON sm.product_id = p.product_id
                    WHERE sm.stock_name LIKE :search_term";
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