<?php
class ProductListModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getProductStockList() {
        $query = "
            SELECT 
                p.product_id,
                p.name AS product_name,
                p.description,
                p.price,
                p.unit,
                sm.stock_id,
                IFNULL(sm.stock_name, 'N/A') AS stock_name,
                IFNULL(SUM(sm.quantity), 0) AS quantity
            FROM vc1_db.products p
            LEFT JOIN vc1_db.stock_management sm ON p.product_id = sm.product_id
            GROUP BY p.product_id, p.name, p.description, p.price, p.unit, sm.stock_id, sm.stock_name
        ";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProductByName($name) {
        $query = "
            SELECT 
                p.product_id,
                p.name AS product_name,
                p.description,
                p.price,
                p.unit,
                sm.stock_id,
                IFNULL(sm.stock_name, 'N/A') AS stock_name,
                IFNULL(SUM(sm.quantity), 0) AS quantity
            FROM vc1_db.products p
            LEFT JOIN vc1_db.stock_management sm ON p.product_id = sm.product_id
            WHERE LOWER(p.name) LIKE LOWER(:search)
            GROUP BY p.product_id, p.name, p.description, p.price, p.unit, sm.stock_id, sm.stock_name
        ";
        return $this->db->query($query, [':search' => "%{$name}%"])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductListById($product_id) {
        $query = "
            SELECT 
                p.product_id,
                p.name AS product_name,
                p.description,
                p.price,
                p.unit,
                sm.stock_id,
                IFNULL(sm.stock_name, 'N/A') AS stock_name,
                IFNULL(SUM(sm.quantity), 0) AS quantity
            FROM vc1_db.products p
            LEFT JOIN vc1_db.stock_management sm ON p.product_id = sm.product_id
            WHERE p.product_id = :product_id
            GROUP BY p.product_id, p.name, p.description, p.price, p.unit, sm.stock_id, sm.stock_name
        ";
        return $this->db->query($query, [':product_id' => $product_id])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProduct($product_id, $name, $description, $price, $unit) {
        $query = "
            UPDATE vc1_db.products 
            SET name = :name, description = :description, price = :price, unit = :unit
            WHERE product_id = :product_id
        ";
        return $this->db->query($query, [
            ':product_id' => $product_id,
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':unit' => $unit
        ]);
    }

    public function deleteProduct($product_id) {
        $query = "DELETE FROM vc1_db.products WHERE product_id = :product_id";
        return $this->db->query($query, [':product_id' => $product_id]);
    }
}
?>