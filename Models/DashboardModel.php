<?php
class DashboardModel 
{
    private $db;
    
    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getAllProducts(){
        $result = $this->db->query("SELECT * FROM products");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProducts()
    {
        $result = $this->db->query("SELECT COUNT(*) FROM products");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['COUNT(*)'];
    }

    public function getTotalQuantity(){
        $result = $this->db->query("SELECT SUM(quantity) AS total_quantity FROM products");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['total_quantity'] ?? 0;
    }

    public function getTotalPrice(){
        $result = $this->db->query("SELECT SUM(price * quantity) AS total_price FROM products");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['total_price'] ?? 0;
    }

    public function getLowStockCount()
    {
        $result = $this->db->query("SELECT COUNT(*) AS low_stock_count FROM products WHERE quantity < 10");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['low_stock_count'] ?? 0;
    }

    public function getLowStockProducts() {
        $query = "SELECT * FROM products WHERE quantity < 10 ORDER BY quantity ASC";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProductsPercentage()
    {
        $totalProducts = $this->getTotalProducts();
        $maxProducts = 650;
        if ($maxProducts == 0){
            return 0;
        }
        $percentage = ($totalProducts / $maxProducts) * 100;
        return round($percentage, 2);
    }

    public function getLowStockPercentage() {
        $lowStockCount = $this->getLowStockCount();  
        $maxProducts = 600;  
        if ($maxProducts == 0) {
            return 0;  
        }
        $percentage = ($lowStockCount / $maxProducts) * 100; 
        return round($percentage, 2);  
    }
}