<?php

require_once "Models/SupplierModel.php";

class SupplierController extends BaseController
{
    private $supply;

    public function __construct() {
        $this->supply = new SupplierModel();
    }

    public function supplier() {
        $result = $this->supply->getSupplier();
        $this->view('users/supplier', ['suppliers' => $result]); // Fixed variable name
    }
}
?>
