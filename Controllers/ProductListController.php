<?php

class ProductListController extends BaseController
{
    public function product_list() {
        $this->view('products/product_list');
    }
}
?>