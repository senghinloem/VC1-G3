<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/WelcomeController.php";
require_once "Controllers/DashboardController.php";
require_once "Controllers/ProductController.php";
require_once "Controllers/StockController.php";
require_once "Controllers/ProductListController.php";
require_once "Controllers/SupplierController.php";
require_once "Controllers/LoginRegisterController.php";



$route = new Router();

// user
$route->get("/users", [UserController::class, 'user']);

$route->get("/", [WelcomeController::class, 'welcome']);
$route->get("/dashboard", [DashboardController::class, 'dashboard']);
// product
$route->get("/products", [ProductController::class, 'product']);
$route->get("/create", [ProductController::class, 'create']);
$route->post("/products/store", [ProductController::class, 'store']);
$route->delete("/products/destroy/{product_id}", [ProductController::class, 'delete']);


// stock
$route->get("/stock", [StockController::class, 'stock']);

// product lsit
$route->get("/product_list", [ProductListController::class, 'product_list']);
$route->get("/product_list/create_list", [ProductListController::class, 'create_list']);
$route->post("/product_list/store", [ProductListController::class, 'store']);
$route->get("/product_list/edit/{product_list_id}", [ProductListController::class, 'edit']);
$route->put("/product_list/update/{product_list_id}", [ProductListController::class, 'update']);
$route->delete("/product_list/destroy/{product_list_id}", [ProductListController::class, 'destroy']);

// suppliers
$route->get("/supplier", [SupplierController::class, 'supplier']);
$route->get("/create_suppliers", [SupplierController::class, 'create']);

// login and register
$route->get("/login", [LoginRegisterController::class, 'login']);
$route->get("/register", [LoginRegisterController::class, 'register']);
$route->route();