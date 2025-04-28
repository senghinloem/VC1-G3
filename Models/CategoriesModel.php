<?php
class CategoriesModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new Database("localhost", "vc1_db", "root", "");
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    // Existing methods...

    public function getCategory() {
        try {
            $result = $this->db->query("SELECT category_id, category_name, description, created_at FROM categories");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching categories: " . $e->getMessage());
        }
    }

    public function getCategoryById($category_id) {
        try {
            $stmt = $this->db->prepare("SELECT category_id, category_name, description, created_at FROM categories WHERE category_id = ?");
            $stmt->execute([$category_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching category: " . $e->getMessage());
        }
    }

    public function createCategory($category_name, $description) {
        try {
            $stmt = $this->db->prepare("INSERT INTO categories (category_name, description) VALUES (?, ?)");
            $stmt->execute([$category_name, $description]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Error creating category: " . $e->getMessage());
        }
    }

    public function updateCategory($category_id, $category_name, $description) {
        try {
            $stmt = $this->db->prepare("UPDATE categories SET category_name = ?, description = ? WHERE category_id = ?");
            return $stmt->execute([$category_name, $description, $category_id]);
        } catch (PDOException $e) {
            throw new Exception("Error updating category: " . $e->getMessage());
        }
    }

    public function deleteCategory($category_id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM categories WHERE category_id = ?");
            return $stmt->execute([$category_id]);
        } catch (PDOException $e) {
            throw new Exception("Error deleting category: " . $e->getMessage());
        }
    }

    public function getAllProducts() {
        try {
            $stmt = $this->db->prepare("SELECT product_id, name FROM products ORDER BY name");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching products: " . $e->getMessage());
        }
    }

    public function assignProductsToCategory($category_id, $product_ids) {
        try {
            // Clear existing assignments (optional, depending on your requirements)
            $this->clearProductsFromCategory($category_id);
            // Assign new products
            $stmt = $this->db->prepare("UPDATE products SET category_id = ? WHERE product_id = ?");
            foreach ($product_ids as $product_id) {
                $stmt->execute([$category_id, $product_id]);
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error assigning products to category: " . $e->getMessage());
        }
    }

    public function clearProductsFromCategory($category_id) {
        try {
            $stmt = $this->db->prepare("UPDATE products SET category_id = NULL WHERE category_id = ?");
            $stmt->execute([$category_id]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error clearing products from category: " . $e->getMessage());
        }
    }

    public function getProductsByCategory($category_id) {
        try {
            $stmt = $this->db->prepare("SELECT product_id, name, description, price, unit, quantity FROM products WHERE category_id = ? ORDER BY name");
            $stmt->execute([$category_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching products for category: " . $e->getMessage());
        }
    }

    public function searchCategories($query) {
        try {
            $stmt = $this->db->prepare("
                SELECT category_id, category_name, description, created_at 
                FROM categories 
                WHERE category_name LIKE ? OR description LIKE ?
                ORDER BY category_name
            ");
            $searchTerm = "%" . $query . "%";
            $stmt->execute([$searchTerm, $searchTerm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error searching categories: " . $e->getMessage());
        }
    }
}
?>