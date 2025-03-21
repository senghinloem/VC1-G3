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
require_once "Controllers/UserController.php";


$route = new Router();

// user
$route->get("/users", [UserController::class, 'user']);
$route->get("/users/create", [UserController::class, 'create']);
$route->post("/users/store", [UserController::class, 'store']);
$route->get("/users/edit/{user_id}", [UserController::class, 'edit']); 
$route->put("/users/update/{user_id}", [UserController::class, 'update']);
$route->delete("/users/destroy/{user_id}", [UserController::class, 'destroy']);
$route->post("/users/authenticate", [UserController::class, 'authenticate']);
$route->get ("/users/logout", [UserController::class, 'logout']);
$route->get("/users/search", [UserController::class, 'search']);

// welcome
$route->get("/", [WelcomeController::class, 'welcome']);
$route->get("/dashboard", [DashboardController::class, 'dashboard']);

// product_management
$route->get("/products", [ProductController::class, 'product']);
$route->get("/create", [ProductController::class, 'create']);
$route->post("/products/store", [ProductController::class, 'store']);
$route->delete("/products/destroy/{product_id}", [ProductController::class, 'delete']);

// stock routes
$route->get("/stock", [StockController::class, 'stock']);
$route->get("/stock/create", [StockController::class, 'create_stock']);
$route->post("/stock/store", [StockController::class, 'store']);
$route->get("/stock/edit/{stock_id}", [StockController::class, 'edit']);
$route->post("/stock/update/{stock_id}", [StockController::class, 'update']);
$route->post("/stock/destroy/{stock_id}", [StockController::class, 'destroy']);
$route->get("/stock/view/{stock_id}", [StockController::class, 'view_stock']);

// product list
$route->get("/product_list", [ProductListController::class, 'product_list']);
$route->get("/product_list/create_list", [ProductListController::class, 'create_list']);
$route->post("/product_list/store", [ProductListController::class, 'store']);
$route->get("/product_list/edit/{product_list_id}", [ProductListController::class, 'edit']);
$route->put("/product_list/update/{product_list_id}", [ProductListController::class, 'update']);
$route->delete("/product_list/destroy/{product_list_id}", [ProductListController::class, 'destroy']);
$route->get('/product_list/search', [ProductListController::class, 'search']);


// suppliers
$route->get("/supplier", [SupplierController::class, 'supplier']);
$route->get("/supplier/create", [SupplierController::class, 'create']);
$route->put("/supplier/store", [SupplierController::class, 'store']);
$route->post("/supplier/update/{supplier_id}", [SupplierController::class, 'update']);
$route->get("/supplier/edit/{supplier_id}", [SupplierController::class, 'edit']);
$route->delete("/supplier/destroy/{supplier_id}", [SupplierController::class, 'destroy']);
$route->get("/supplier/detail/{supplier_id}", [SupplierController::class, 'detail']);

// login and register
$route->get("/login", [LoginRegisterController::class, 'login']);
$route->get("/register", [LoginRegisterController::class, 'register']);
$route->get("/error", [LoginRegisterController::class, 'error']);

$route->route();
