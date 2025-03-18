<?php

class ProductModel 

{
    private $db;

    public function __construct(){
        $this->db = new Database ("localhost", "vc1_db", "root", "");

    }

    public function getAllProducts(){
        $result = $this->db->query("SELECT * FROM products");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductListById($product_id)

    {
        $result = $this->db->query("SELECT * FROM $product_id WHERE product_id = :product_id", ['product_id'=>$product_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduct($image, $name, $description, $price, $unit, $quantity)
    {
        try {
            $this->db->query("INSERT INTO products(image,name, description, price, unit, quantity) VALUES (:image, :name, :description, :price, :unit, :quantity)", [
                ':image' => $image,
                ':name' => $name,
                ':description' => $description,
                ':price' => $price,
                ':unit' => $unit,
                ':quantity' => $quantity,
            ]);
        } catch (PDOException $e) {
            echo "Error adding product: " . $e->getMessage();
        }
    }

    public function deleteProduct($product_id)
    {
        try {
            $this->db->query("DELETE FROM products WHERE product_id = :product_id", ['product_id' => $product_id]);
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
        }
    }
}

?>