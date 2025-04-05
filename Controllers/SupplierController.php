<?php

require_once "Models/SupplierModel.php";

class SupplierController extends BaseController
{
    private $supply;

    public function __construct() {
        $this->supply = new SupplierModel();
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function supplier() {
        $result = $this->supply->getSupplier();
        $this->view('users/supplier', ['suppliers' => $result]);
    }

    public function create() {
        $this->view('users/create_supplier');
    }

    public function store() {
        $supplier_name = $_POST['supplier_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        try {
            $this->supply->addSupplier($supplier_name, $email, $phone, $address);
            $_SESSION['success_message'] = "Supplier '$supplier_name' successfully created!";
            header("Location: /supplier");
            exit();
        } catch(PDOException $e) {
            // You might want to handle this error better in production
            $_SESSION['error_message'] = "Error creating supplier: " . $e->getMessage();
            header("Location: /supplier/create");
            exit();
        }
    }

    public function edit($supplier_id) {
        $supplier = $this->supply->getSupplierById($supplier_id);
        $this->view('users/edit_supplier', ['supplier' => $supplier]);
    }

    public function update($supplier_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
            $supplier_name = $_POST['supplier_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            try {
                $this->supply->updateSupplier($supplier_id, $supplier_name, $email, $phone, $address);
                $_SESSION['success_message'] = "Supplier '$supplier_name' successfully updated!";
                header("Location: /supplier");
                exit();
            } catch(PDOException $e) {
                $_SESSION['error_message'] = "Error updating supplier: " . $e->getMessage();
                header("Location: /supplier/edit/$supplier_id");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Invalid method for updating supplier.";
            header("Location: /supplier");
            exit();
        }
    }

    public function detail($supplier_id) {
        $supplier = $this->supply->getSupplierById($supplier_id);
        $this->view('users/supplier_detail', ['supplier' => $supplier]);
    }

    public function destroy($supplier_id) {
        try {
            $supplier = $this->supply->getSupplierById($supplier_id); // Get supplier name before deleting
            $supplier_name = $supplier['supplier_name'];
            $this->supply->deleteSupplier($supplier_id);
            $_SESSION['success_message'] = "Supplier '$supplier_name' successfully deleted!";
            header('Location: /supplier');
            exit();
        } catch(PDOException $e) {
            $_SESSION['error_message'] = "Error deleting supplier: " . $e->getMessage();
            header('Location: /supplier');
            exit();
        }
    }
}
?>