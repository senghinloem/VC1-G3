<?php

class SupplierController extends BaseController
{
    public function supplier() {
        $this->view('users/supplier');
    }

    public function create() {
        $this->view('users/create');
    }
}

?>