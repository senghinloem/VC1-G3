<?php
require_once "Models/SupplierModel.php";
require_once "Models/NotificationModel.php";
require_once "Models/ProductModel.php";

class SupplierController extends BaseController {
    private $supply;
    private $notification;
    private $productModel;

    public function __construct() {
        $this->supply = new SupplierModel();
        $this->notification = new NotificationModel();
        $this->productModel = new ProductModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function supplier() {
        try {
            $result = $this->supply->getSupplier();
            $this->view('users/supplier', ['suppliers' => $result]);
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error loading suppliers: " . $e->getMessage();
            $this->view('users/supplier', ['suppliers' => []]);
        }
    }

    public function create() {
        try {
            $products = $this->productModel->getProducts();
            $this->view('users/create_supplier', ['products' => $products]);
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error loading products: " . $e->getMessage();
            $this->view('users/create_supplier', ['products' => []]);
        }
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Invalid request method";
            header("Location: /supplier/create");
            exit();
        }

        $supplier_name = trim($_POST['supplier_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $products = isset($_POST['products']) ? $_POST['products'] : [];

        // Basic validation
        if (empty($supplier_name) || empty($email)) {
            $_SESSION['error_message'] = "Supplier name and email are required";
            header("Location: /supplier/create");
            exit();
        }

        try {
            // Validate product IDs if any
            if (!empty($products) && !$this->productModel->validateProductIds($products)) {
                $_SESSION['error_message'] = "Invalid product selected";
                header("Location: /supplier/create");
                exit();
            }

            $supplier_id = $this->supply->addSupplier($supplier_name, $email, $phone, $address, $products);
            
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "New supplier '$supplier_name' added",
                'success'
            );
            
            $_SESSION['success_message'] = "Supplier '$supplier_name' successfully created!";
            header("Location: /supplier");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error creating supplier: " . $e->getMessage();
            header("Location: /supplier/create");
            exit();
        }
    }

    public function edit($supplier_id) {
        try {
            $supplier = $this->supply->getSupplierById($supplier_id);
            if (!$supplier) {
                $_SESSION['error_message'] = "Supplier not found";
                header("Location: /supplier");
                exit();
            }
            
            $products = $this->productModel->getProducts();
            $this->view('users/edit_supplier', [
                'supplier' => $supplier,
                'products' => $products
            ]);
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error loading supplier: " . $e->getMessage();
            header("Location: /supplier");
            exit();
        }
    }

    public function update($supplier_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Invalid request method";
            header("Location: /supplier");
            exit();
        }

        $supplier_name = trim($_POST['supplier_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);

        try {
            $this->supply->updateSupplier($supplier_id, $supplier_name, $email, $phone, $address);
            
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Supplier '$supplier_name' updated",
                'success'
            );
            
            $_SESSION['success_message'] = "Supplier '$supplier_name' successfully updated!";
            header("Location: /supplier");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error updating supplier: " . $e->getMessage();
            header("Location: /supplier/edit/$supplier_id");
            exit();
        }
    }

    public function detail($supplier_id) {
        try {
            $supplier = $this->supply->getSupplierById($supplier_id);
            if (!$supplier) {
                $_SESSION['error_message'] = "Supplier not found";
                header("Location: /supplier");
                exit();
            }
            $this->view('users/supplier_detail', ['supplier' => $supplier]);
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error loading supplier details: " . $e->getMessage();
            header("Location: /supplier");
            exit();
        }
    }

    public function destroy($supplier_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Invalid request method";
            header("Location: /supplier");
            exit();
        }

        try {
            $supplier = $this->supply->getSupplierById($supplier_id);
            if (!$supplier) {
                $_SESSION['error_message'] = "Supplier not found";
                header('Location: /supplier');
                exit();
            }
            
            $supplier_name = $supplier['supplier_name'];
            $this->supply->deleteSupplier($supplier_id);
            
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Supplier '$supplier_name' deleted",
                'success'
            );
            
            $_SESSION['success_message'] = "Supplier '$supplier_name' successfully deleted!";
            header('Location: /supplier');
            exit();
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error deleting supplier: " . $e->getMessage();
            header('Location: /supplier');
            exit();
        }
    }
}