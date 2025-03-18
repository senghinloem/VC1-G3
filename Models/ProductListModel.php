<?php
class ProductListModel
{
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
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
                    IFNULL(SUM(sm.quantity), 0) AS quantity
                FROM vc1_db.products p
                LEFT JOIN vc1_db.stock_management sm ON p.product_id = sm.product_id
                GROUP BY p.product_id, p.name, p.description, p.price, p.unit, sm.stock_id
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
                IFNULL(SUM(sm.quantity), 0) AS quantity
            FROM vc1_db.products p
            LEFT JOIN vc1_db.stock_management sm ON p.product_id = sm.product_id
            WHERE LOWER(p.name) LIKE LOWER(:search)
            GROUP BY p.product_id, p.name, p.description, p.price, p.unit, sm.stock_id
        ";
    
        return $this->db->query($query, [':search' => "%{$name}%"])->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
