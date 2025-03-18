<?php
class ProductListModel
{
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    // Search products by name
    public function searchProductByName($name) {
        $query = "
            SELECT 
                p.product_id,
                p.name AS product_name,
                p.description,
                p.price,
                p.unit,
                sm.stock_id,
                COALESCE(sm.stock_name, 'N/A') AS stock_name,
                COALESCE(sm.quantity, 0) AS quantity
            FROM vc1_db.products p
            LEFT JOIN vc1_db.stock_management sm ON p.product_id = sm.product_id
            WHERE LOWER(p.name) LIKE LOWER(:search) 
                OR LOWER(COALESCE(sm.stock_name, '')) LIKE LOWER(:search)
        ";

        return $this->db->query($query, [':search' => "%{$name}%"])->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all products with stock details
    public function getProductStockList() {
        $query = "
            SELECT 
                p.product_id,
                p.name AS product_name,
                p.description,
                p.price,
                p.unit,
                sm.stock_id,
                COALESCE(sm.stock_name, 'N/A') AS stock_name,
                COALESCE(sm.quantity, 0) AS quantity
            FROM vc1_db.products p
            LEFT JOIN vc1_db.stock_management sm ON p.product_id = sm.product_id
        ";

        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}
