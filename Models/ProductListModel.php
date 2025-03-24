<?php
class ProductListModel
{
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
                IFNULL(SUM(sm.quantity), 0) AS quantity
            FROM vc1_db.products p
            LEFT JOIN vc1_db.stock_management sm ON p.product_id = sm.product_id
            GROUP BY p.product_id, p.name, p.description, p.price, p.unit
        ";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $query = "SELECT * FROM vc1_db.products WHERE product_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduct($id, $name, $description, $price, $unit) {
        $query = "
            UPDATE vc1_db.products 
            SET name = :name, description = :description, price = :price, unit = :unit 
            WHERE product_id = :id
        ";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':unit' => $unit
        ]);
        if (!$result) {
            print_r($stmt->errorInfo()); // Debug SQL errors
            return false;
        }
        return $result;
    }

    // Placeholder for deleteProduct (since it’s referenced but not shown)
    public function deleteProduct($id) {
        $query = "DELETE FROM vc1_db.products WHERE product_id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function searchProductByName($name) {
        $query = "
            SELECT 
                p.product_id,
                p.name AS product_name,
                p.description,
                p.price,
                p.unit,
                IFNULL(SUM(sm.quantity), 0) AS quantity
            FROM vc1_db.products p
            LEFT JOIN vc1_db.stock_management sm ON p.product_id = sm.product_id
            WHERE LOWER(p.name) LIKE LOWER(:search)
            GROUP BY p.product_id, p.name, p.description, p.price, p.unit
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':search' => "%{$name}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}