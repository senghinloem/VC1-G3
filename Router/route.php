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
require_once "Controllers/HelpController.php";
require_once "Controllers/SettingController.php";
require_once "Controllers/ReportController.php";
require_once "Controllers/NotificationController.php";
require_once "Controllers/CategoriesController.php";

$route = new Router();

// user
$route->get("/users", [UserController::class, 'user']);
$route->get("/users/create", [UserController::class, 'create']);
$route->post("/users/store", [UserController::class, 'store']);
$route->get("/users/edit/{user_id}", [UserController::class, 'edit']); 
$route->put("/users/update/{user_id}", [UserController::class, 'update']);
$route->delete("/users/destroy/{user_id}", [UserController::class, 'destroy']);
$route->post("/users/authenticate", [UserController::class, 'authenticate']);
$route->get("/users/logout", [UserController::class, 'logout']);
$route->get("/users/search", [UserController::class, 'search']);
$route->get("/users/detail/{user_id}", [UserController::class, 'userDetail']);
$route->get("/users/profile", [UserController::class, 'profile']);

// welcome
$route->get("/", [WelcomeController::class, 'welcome']);
$route->get("/dashboard", [DashboardController::class, 'dashboard']);

// product_management
$route->get("/products", [ProductController::class, 'product']);
$route->get("/create", [ProductController::class, 'create']);
$route->post("/products/store", [ProductController::class, 'store']);
$route->post("/products/destroy/multiple", [ProductController::class, 'deleteMultiple']);
$route->post("/products/import", [ProductController::class, 'import']);

// Stock Management
$route->get("/stock", [StockController::class, 'stock']);
$route->get("/stock/create", [StockController::class, 'create_stock']);
$route->post("/stock/store", [StockController::class, 'store']);
$route->get("/stock/view/{stock_id}", [StockController::class, 'view_detail']);
$route->get("/stock/edit/{stock_id}", [StockController::class, 'edit']);
$route->post("/stock/update/{stock_id}", [StockController::class, 'update']);
$route->delete("/stock/delete/{stock_id}", [StockController::class, 'destroy']);
$route->get("/stock/search", [StockController::class, 'search']);
$route->post("/stock/adjust/{stock_id}", [StockController::class, 'adjust']);


// product list
$route->get("/product_list", [ProductListController::class, 'product_list']);
$route->get("/product_list/create_list", [ProductListController::class, 'create_list']);
$route->post("/product_list/store", [ProductListController::class, 'store']);
$route->get("/product_list/edit/{id}", [ProductListController::class, 'edit']);
$route->post("/product_list/update/{id}", [ProductListController::class, 'update']);
$route->delete("/product_list/destroy/{id}", [ProductListController::class, 'destroy']);
$route->get('/product_list/search', [ProductListController::class, 'search']);
$route->post("/products/assign-stock", [ProductController::class, 'assignStock']);

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

// help
$route->get("/help", [HelpController::class, 'help']);

// setting
$route->get("/setting", [SettingController::class, 'setting']);

// report
$route->get("/report", [ReportController::class, "report"]);

// notifications
$route->get("/notifications", [NotificationController::class, 'index']);
$route->post("/notifications/mark-all-read", [NotificationController::class, 'markAllAsRead']);
// $route->post("/notifications/mark-read/{notification_id}", [NotificationController::class, 'markAsRead']);
$route->post("/notifications/delete/{notification_id}", [NotificationController::class, 'delete']);

// categories
$route->get("/category", [CategoriesController::class, "category"]);
$route->get("/category/create", [CategoriesController::class, "create"]);
$route->post("/category/create", [CategoriesController::class, "create"]);
$route->get("/category/edit/{category_id}", [CategoriesController::class, "edit"]);
$route->post("/category/edit/{category_id}", [CategoriesController::class, "edit"]);
$route->get("/category/delete/{category_id}", [CategoriesController::class, "delete"]);
$route->get("/categories/category/show/{category_id}", [CategoriesController::class, "show"]);
// In your routes file
$route->get('/categories/search', [CategoriesController::class, "search"]);

$route->route();
?>