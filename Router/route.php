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
require_once "Controllers/UserController.php"; // Added missing UserController

$route = new Router();

// user
$route->get("/users", [UserController::class, 'user']);
$route->get("/users/create", [UserController::class, 'create']);
$route->post("/users/store", [UserController::class, 'store']);
$route->get("/users/edit/{user_id}", [UserController::class, 'edit']); 
$route->put("/users/update/{user_id}", [UserController::class, 'update']);
$route->delete("/users/destroy/{user_id}", [UserController::class, 'destroy']); 
// welcome
$route->get("/", [WelcomeController::class, 'welcome']);
$route->get("/dashboard", [DashboardController::class, 'dashboard']);
// product
$route->get("/products", [ProductController::class, 'product']);
$route->get("/create", [ProductController::class, 'create']);

// stock
$route->get("/stock", [StockController::class, 'stock']);

// product list
$route->get("/product_list", [ProductListController::class, 'product_list']);
$route->get("/product_list/create_list", [ProductListController::class, 'create_list']);
$route->post("/product_list/store", [ProductListController::class, 'store']);
$route->get("/product_list/edit/{product_list_id}", [ProductListController::class, 'edit']);
$route->put("/product_list/update/{product_list_id}", [ProductListController::class, 'update']);
$route->delete("/product_list/destroy/{product_list_id}", [ProductListController::class, 'destroy']);
$route->get("/product_list/view_detail/{product_list_id}", [ProductListController::class, 'viewDetailProductList']);


// suppliers
$route->get("/supplier", [SupplierController::class, 'supplier']);
$route->get("/create_suppliers", [SupplierController::class, 'create']);

// login and register
$route->get("/login", [LoginRegisterController::class, 'login']);
$route->get("/register", [LoginRegisterController::class, 'register']);

$route->route();