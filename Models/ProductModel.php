<?php
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getAllProducts() {
        $result = $this->db->query("SELECT * FROM products");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($product_id) {
        $result = $this->db->query("SELECT * FROM products WHERE product_id = :product_id", ['product_id' => $product_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduct($image, $name, $description, $price, $unit, $quantity, $category_id)
    {
        try {
            $this->db->query("INSERT INTO products (image, name, description, price, unit, quantity, category_id) VALUES (:image, :name, :description, :price, :unit, :quantity, :category_id)", [
                ':image' => $image,
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':unit' => $unit,
                ':quantity' => $quantity,
                ':category_id' => $category_id 
            ]);
        } catch (PDOException $e) {
            echo "Error adding product: " . $e->getMessage();
        }
    }

    public function deleteProduct($product_id) {
        try {
            $this->db->query("DELETE FROM products WHERE product_id = :product_id", ['product_id' => $product_id]);
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
        }
    }

    public function deleteMultipleProducts($product_ids) {
        try {
            if (!empty($product_ids)) {
                $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
                $query = "DELETE FROM products WHERE product_id IN ($placeholders)";
                $this->db->query($query, $product_ids);
            }
        } catch (PDOException $e) {
            echo "Error deleting products: " . $e->getMessage();
        }
    }

    public function getAllStocks() {
        $result = $this->db->query("SELECT * FROM stock_management");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignProductToStock($productId, $stockId) {
        $result = $this->db->query(
            "UPDATE products SET stock_id = :stock_id WHERE product_id = :product_id",
            [
                ':stock_id' => $stockId,
                ':product_id' => $productId
            ]
        );
        return $result->rowCount() > 0;
    }
}
?>