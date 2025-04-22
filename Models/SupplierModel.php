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
        $supplierQuery = "SELECT * FROM suppliers WHERE supplier_id = :supplier_id";
        $supplierResult = $this->db->query($supplierQuery, [':supplier_id' => $supplier_id]);
        $supplier = $supplierResult->fetch(PDO::FETCH_ASSOC);

        if ($supplier) {
            $productsQuery = "
                SELECT p.product_id, p.name AS product_name, p.price, p.quantity AS stock
                FROM products p
                INNER JOIN supplier_provide_product spp ON p.product_id = spp.product_id
                WHERE spp.supplier_id = :supplier_id
            ";
            $productsResult = $this->db->query($productsQuery, [':supplier_id' => $supplier_id]);
            $products = $productsResult->fetchAll(PDO::FETCH_ASSOC);
            $supplier['products'] = $products;
        }

        return $supplier ?: [];
    }

    public function addSupplier($supplier_name, $email, $phone, $address, $products = []) {
        try {
            $this->db->beginTransaction();

            // Insert the supplier
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

            // Get the last inserted supplier_id
            $supplier_id = $this->db->lastInsertId();
            
            if (!$supplier_id) {
                throw new PDOException("Failed to get the supplier ID after insertion");
            }

            // Insert product relationships if any
            if (!empty($products)) {
                foreach ($products as $product_id) {
                    $this->db->query(
                        "INSERT INTO supplier_provide_product (supplier_id, product_id) 
                         VALUES (:supplier_id, :product_id)",
                        [
                            ':supplier_id' => $supplier_id,
                            ':product_id' => $product_id
                        ]
                    );
                }
            }

            $this->db->commit();
            return $supplier_id;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("SupplierModel::addSupplier error: " . $e->getMessage());
            throw $e;
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
            return true;
        } catch (PDOException $e) {
            error_log("SupplierModel::updateSupplier error: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteSupplier($supplier_id) {
        try {
            $this->db->beginTransaction();
            
            // First delete the product relationships
            $this->db->query(
                "DELETE FROM supplier_provide_product WHERE supplier_id = :supplier_id",
                [':supplier_id' => $supplier_id]
            );
            
            // Then delete the supplier
            $this->db->query(
                "DELETE FROM suppliers WHERE supplier_id = :supplier_id",
                [':supplier_id' => $supplier_id]
            );
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("SupplierModel::deleteSupplier error: " . $e->getMessage());
            throw $e;
        }
    }
}