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

}