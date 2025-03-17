<?php
class ProductListModel
{
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getProductList() {
        $result = $this->db->query("SELECT * FROM product_list");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getProductListById($product_list_id) {
        $result = $this->db->query("SELECT * FROM product_list WHERE product_list_id = :product_list_id", ['product_list_id' => $product_list_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addProductList($image, $name, $available_quantity, $price) {
        try {
            $this->db->query("INSERT INTO product_list (image, name, available_quantity, price) VALUES (:image, :name, :available_quantity, :price)", [
                ':image' => $image,
                ':name' => $name,
                ':available_quantity' => $available_quantity,
                ':price' => $price
            ]);
        } catch (PDOException $e) {
            echo "Error adding product: " . $e->getMessage();
        }
    }

    public function updateProductList($product_list_id, $image, $name, $available_quantity, $price) {
        try {
            $query = "UPDATE product_list SET name = :name, available_quantity = :available_quantity, price = :price";
            $params = [
                ':product_list_id' => $product_list_id,
                ':name' => $name,
                ':available_quantity' => $available_quantity,
                ':price' => $price
            ];
            if ($image) {
                $query .= ", image = :image";
                $params[':image'] = $image;
            }
            $query .= " WHERE product_list_id = :product_list_id";
            $this->db->query($query, $params);
        } catch (PDOException $e) {
            echo "Error updating product: " . $e->getMessage();
        }
    }

    public function deleteProductList($product_list_id) {
        try {
            $this->db->query("DELETE FROM product_list WHERE product_list_id = :product_list_id", ['product_list_id' => $product_list_id]);
        } catch (PDOException $e) {
            echo "Error deleting product: " . $e->getMessage();
        }
    }

    public function searchProductByName($name) {
        $query = "SELECT * FROM product_list WHERE name LIKE :name";
        $products = $this->db->query($query, [':name' => "%$name%"])->fetchAll(PDO::FETCH_ASSOC);
        
        // Ensure the image path is correct
        foreach ($products as &$product) {
            $product['image'] = "/uploads/" . basename($product['image']); // Update image path
        }

        return $products;
    }
}
