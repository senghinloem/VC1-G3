<?php
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getAllProducts() {
        try {
            $result = $this->db->query("SELECT * FROM products");
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
            // Basic input validation
            if (empty($name) || !is_numeric($price) || !is_numeric($quantity)) {
                throw new Exception("Invalid product data");
            }
            $this->db->query(
                "INSERT INTO products (image, name, description, price, unit, quantity) VALUES (:image, :name, :description, :price, :unit, :quantity)",
                [
                    ':image' => $image,
                    ':name' => $name,
                    ':description' => $description,
                    ':price' => $price,
                    ':unit' => $unit,
                    ':quantity' => $quantity,
                ]
            );
            return true;
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
                return true; // No products to delete
            }
            // Validate product IDs
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
            $result = $this->db->query(
                "UPDATE products SET stock_id = :stock_id WHERE product_id = :product_id",
                [
                    ':stock_id' => $stockId,
                    ':product_id' => $productId
                ]
            );
            return $result->rowCount() > 0;
        } catch (PDOException $e) {
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
                return true; // No products selected is valid
            }
            // Ensure all IDs are numeric
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
}
?>