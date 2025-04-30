<?php
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getAllProducts() {
        try {
            $query = "SELECT p.*, sm.stock_name, sm.stock_id 
                      FROM products p
                      LEFT JOIN stock_management sm ON p.product_id = sm.product_id";
            $result = $this->db->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching products: " . $e->getMessage());
        }
    }

    public function getProductById($product_id) {
        try {
            if (!is_numeric($product_id)) {
                throw new Exception("Invalid product ID");
            }
            $result = $this->db->query("SELECT * FROM products WHERE product_id = :product_id", ['product_id' => $product_id]);
            return $result->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            throw new Exception("Error fetching product: " . $e->getMessage());
        }
    }

    public function addProduct($image, $name, $description, $price, $unit, $quantity) {
        try {
            if (empty($name) || !is_numeric($price) || !is_numeric($quantity)) {
                throw new Exception("Invalid product data");
            }
            $this->db->query(
                "INSERT INTO products (image, name, description, price, unit, quantity, created_at) 
                 VALUES (:image, :name, :description, :price, :unit, :quantity, NOW())",
                [
                    ':image' => $image,
                    ':name' => $name,
                    ':description' => $description,
                    ':price' => $price,
                    ':unit' => $unit,
                    ':quantity' => $quantity,
                ]
            );
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Error adding product: " . $e->getMessage());
        }
    }

    public function deleteProduct($product_id) {
        try {
            if (!is_numeric($product_id)) {
                throw new Exception("Invalid product ID");
            }
            $result = $this->db->query("DELETE FROM products WHERE product_id = :product_id", ['product_id' => $product_id]);
            return $result->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Error deleting product: " . $e->getMessage());
        }
    }

    public function deleteMultipleProducts($product_ids) {
        try {
            if (empty($product_ids)) {
                return true;
            }
            if (!$this->validateProductIds($product_ids)) {
                throw new Exception("Invalid product IDs provided");
            }
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $result = $this->db->query("DELETE FROM products WHERE product_id IN ($placeholders)", $product_ids);
            return $result->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Error deleting products: " . $e->getMessage());
        }
    }

    public function getAllStocks() {
        try {
            $result = $this->db->query("SELECT * FROM stock_management");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching stocks: " . $e->getMessage());
        }
    }

    public function assignProductToStock($productId, $stockId) {
        try {
            if (!is_numeric($productId) || !is_numeric($stockId)) {
                throw new Exception("Invalid product or stock ID");
            }
            
            // First check if the product is already assigned to this stock
            $existing = $this->db->query(
                "SELECT * FROM stock_management WHERE product_id = :product_id AND stock_id = :stock_id",
                [':product_id' => $productId, ':stock_id' => $stockId]
            )->fetch();
            
            if ($existing) {
                return true; // Already assigned
            }
            
            // Get the product quantity
            $product = $this->getProductById($productId);
            if (!$product) {
                throw new Exception("Product not found");
            }
            
            // Assign to stock
            $result = $this->db->query(
                "INSERT INTO stock_management (product_id, user_id, stock_name, quantity, status, stock_type, created_at) 
                 VALUES (:product_id, :user_id, :stock_name, :quantity, :status, :stock_type, NOW())",
                [
                    ':product_id' => $productId,
                    ':user_id' => $_SESSION['user_id'],
                    ':stock_name' => 'Assigned Stock',
                    ':quantity' => $product['quantity'],
                    ':status' => 'in_stock',
                    ':stock_type' => 'IN'
                ]
            );
            
            // Update has_stock table
            $this->db->query(
                "INSERT INTO has_stock (product_id, available_quantity) 
                 VALUES (:product_id, :quantity)
                 ON DUPLICATE KEY UPDATE available_quantity = :quantity",
                [
                    ':product_id' => $productId,
                    ':quantity' => $product['quantity']
                ]
            );
            
            return $result->rowCount() > 0;
        } catch (Exception $e) {
            throw new Exception("Error assigning product to stock: " . $e->getMessage());
        }
    }

    public function getProducts() {
        try {
            $result = $this->db->query("SELECT product_id, name FROM products");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching products: " . $e->getMessage());
        }
    }

    public function validateProductIds($productIds) {
        try {
            if (empty($productIds)) {
                return true;
            }
            if (!array_reduce($productIds, fn($carry, $id) => $carry && is_numeric($id), true)) {
                return false;
            }
            $placeholders = implode(',', array_fill(0, count($productIds), '?'));
            $result = $this->db->query("SELECT product_id FROM products WHERE product_id IN ($placeholders)", $productIds);
            $validIds = array_column($result->fetchAll(PDO::FETCH_ASSOC), 'product_id');
            return count($productIds) === count(array_intersect($productIds, $validIds));
        } catch (PDOException $e) {
            throw new Exception("Error validating product IDs: " . $e->getMessage());
        }
    }

    public function getTotalProductsCount() {
        try {
            $result = $this->db->query("SELECT COUNT(*) as total FROM products");
            return $result->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            throw new Exception("Error fetching total products count: " . $e->getMessage());
        }
    }
    
    public function getNewProductsAddedCount($days = 7) {
        try {
            $result = $this->db->query(
                "SELECT COUNT(*) as count FROM products 
                 WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)",
                [':days' => $days]
            );
            return $result->fetch(PDO::FETCH_ASSOC)['count'];
        } catch (PDOException $e) {
            throw new Exception("Error fetching new products count: " . $e->getMessage());
        }
    }
    
    public function getAssignedProductsCount($days = 7) {
        try {
            $result = $this->db->query(
                "SELECT COUNT(DISTINCT product_id) as count FROM stock_management 
                 WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)",
                [':days' => $days]
            );
            return $result->fetch(PDO::FETCH_ASSOC)['count'];
        } catch (PDOException $e) {
            throw new Exception("Error fetching assigned products count: " . $e->getMessage());
        }
    }
    
    public function getPendingAssignmentCount() {
        try {
            $result = $this->db->query(
                "SELECT COUNT(*) as count FROM products p
                 LEFT JOIN stock_management sm ON p.product_id = sm.product_id
                 WHERE sm.stock_id IS NULL"
            );
            return $result->fetch(PDO::FETCH_ASSOC)['count'];
        } catch (PDOException $e) {
            throw new Exception("Error fetching pending assignment count: " . $e->getMessage());
        }
    }
}
?>