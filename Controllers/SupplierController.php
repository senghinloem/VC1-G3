<?php

require_once "Models/SupplierModel.php";

class SupplierController extends BaseController
{
    private $supply;

    public function __construct() {
        $this->supply = new SupplierModel();
<<<<<<< HEAD
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
            header("Location: /supplier");
        } catch(PDOException $e) {
            echo "error";
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
            $this->supply->updateSupplier($supplier_id, $supplier_name, $email, $phone, $address);
            header("Location: /supplier");
        } else {
            echo "Invalid method for updating supplier.";
        }
    }

    public function detail($supplier_id) {
        $supplier = $this->supply->getSupplierById($supplier_id);  // Corrected line
        $this->view('users/supplier_detail', ['supplier' => $supplier]);  // Pass the supplier to the view
    }

    public function destroy($supplier_id) {
        $this->supply->deleteSupplier($supplier_id);
        header('Location: /supplier');
    }
}

=======
    }

    public function supplier() {
        $result = $this->supply->getSupplier();
        $this->view('users/supplier', ['suppliers' => $result]); // Fixed variable name
    }
}
>>>>>>> 3e7eef96232f951822103f82481f073d5cd8de16
?>
