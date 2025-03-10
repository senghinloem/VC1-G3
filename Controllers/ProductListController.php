<?php

require_once "Models/ProductListModel.php";

class ProductListController extends BaseController 
{
    private $list;

    public function __construct()
    {
        $this->list =  new ProductListModel();
    }

    public function product_list() 
    {
        $list = $this->list->getProductList();
        $this->view('products/product_list', ['product_list' => $list]);
    }

    public function create_list() {
        $this->view("products/create_list");
    }


   public function store() {
        $image = $_POST['image'];
        $available_quantity = $_POST['available_quantity'];
        $price = $_POST['price'];
        $this->list->addProductList($image, $available_quantity, $price);
        header("Location: /product_list");
    }

    public function edit($product_list_id) {
        $list = $this->list->getProductListById($product_list_id);
        $this->view('products/edit_list', ['list' => $list]);
    }


    public function update($id) {
        $product_list_id = $_POST['product_list_id'];
        $image = $_POST['image'];
        $available_quantity = $_POST['available_quantity'];
        $price = $_POST['price'];
        $this->list->updatePrudocutList($product_list_id, $image, $available_quantity, $price);
        header("Location: /product_list");
    }

    public function destroy($product_list_id) {
        $this->list->deleteProductList($product_list_id);
        header("Location: /product_list");
    }
}
?>