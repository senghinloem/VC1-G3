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
$route->get("/", [WelcomeController::class, 'welcome']);
$route->get("/dashboard", [DashboardController::class, 'dashboard']);
$route->get("/products", [ProductController::class, 'product']);
$route->get("/create", [ProductController::class, 'create']);
$route->get("/stock", [StockController::class, 'stock']);
$route->get("/product_list", [ProductListController::class, 'product_list']);
$route->get("/supplier", [SupplierController::class, 'supplier']);
$route->get("/create_suppliers", [SupplierController::class, 'create']);
$route->get("/login", [LoginRegisterController::class, 'login']);
$route->get("/register", [LoginRegisterController::class, 'register']);
$route->route();