<?php

class ProductController extends BaseController
{
    public function product() {
        $this->view('products/products');
    }

    public function create() {
        $this->view('products/create');
    }
}

?>