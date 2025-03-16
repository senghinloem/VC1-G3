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

    public function getProductListById($product_list_id)

    {
        $result = $this->db->query("SELECT * FROM product_list WHERE product_list_id = :product_list_id", ['product_list_id'=>$product_list_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addProductList($image, $available_quantity, $price)
    {
        try {
            $this->db->query("INSERT INTO product_list (image, available_quantity, price) VALUES (:image, :available_quantity, :price)", [
                ':image' => $image,
                ':available_quantity' => $available_quantity,
                ':price' => $price
            ]);
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
        }
    }

    public function updateProductList($product_list_id, $image, $available_quantity, $price)
    {
        try {
            $this->db->query(
                "UPDATE product_list SET image = :image, available_quantity = :available_quantity, price = :price WHERE product_list_id = :product_list_id",
                [
                    ':product_list_id' => $product_list_id,
                    ':image' => $image,
                    ':available_quantity' => $available_quantity,
                    ':price' => $price
                ]
            );
        } catch (PDOException $e) {
            echo "Error updating user: " . $e->getMessage();
        }
    }

    public function deleteProductList($product_list_id)
    {
        try {
            $this->db->query("DELETE FROM product_list WHERE product_list_id = :product_list_id", ['product_list_id' => $product_list_id]);
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
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

?>