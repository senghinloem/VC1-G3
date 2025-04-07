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

    public function getSupplierById($supplier_id) {
        $result = $this->db->query("SELECT * FROM suppliers WHERE supplier_id = :supplier_id", [':supplier_id' => $supplier_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addSupplier($supplier_name, $email, $phone, $address) {
        try {
            $this->db->query(
                "INSERT INTO suppliers (supplier_name, email, phone, address, created_at) 
                 VALUES (:supplier_name, :email, :phone, :address, NOW())",
                [
                    ':supplier_name' => $supplier_name,
                    ':email' => $email,
                    ':phone' => $phone,
                    ':address' => $address
                ]
            );
        } catch (PDOException $e) {
            echo "Error adding supplier: " . $e->getMessage();
        }
    }

    public function updateSupplier($supplier_id, $supplier_name, $email, $phone, $address) {
        try {
            $query = "UPDATE suppliers 
                      SET supplier_name = :supplier_name, email = :email, phone = :phone, address = :address 
                      WHERE supplier_id = :supplier_id";
            $params = [
                ':supplier_id' => $supplier_id,
                ':supplier_name' => $supplier_name,
                ':email' => $email,
                ':phone' => $phone,
                ':address' => $address
            ];
            $this->db->query($query, $params);
        } catch (PDOException $e) {
            echo "Error updating supplier: " . $e->getMessage();
        }
    }

    public function deleteSupplier($supplier_id) {
        try {
            $this->db->query("DELETE FROM suppliers WHERE supplier_id = :supplier_id", [':supplier_id' => $supplier_id]);
        } catch (PDOException $e) {
            echo "Error deleting supplier: " . $e->getMessage();
        }
    }
}
?>