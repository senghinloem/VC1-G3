
<?php

class SupplierModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getSupplier() {
        $result = $this->db->query("SELECT * FROM suppliers");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>