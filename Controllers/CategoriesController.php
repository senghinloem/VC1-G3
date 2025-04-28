<?php
require_once __DIR__ . '/../Models/CategoriesModel.php';

class CategoriesController extends BaseController {
    private $categoriesModel;

    public function __construct() {
        $this->categoriesModel = new CategoriesModel();
    }

    public function category() {
        try {
            $categories = $this->categoriesModel->getCategory();
            $data = [
                'categories' => $categories,
                'error' => isset($_GET['error']) ? $_GET['error'] : null,
                'success' => isset($_GET['success']) ? $_GET['success'] : null
            ];
            $this->view('categories/categories', $data);
        } catch (Exception $e) {
            $data = [
                'error' => $e->getMessage(),
                'categories' => []
            ];
            $this->view('categories/categories', $data);
        }
    }

    public function search() {
        $query = trim($_GET['search'] ?? '');
        try {
            if (empty($query)) {
                $categories = $this->categoriesModel->getCategory();
            } else {
                $categories = $this->categoriesModel->searchCategories($query);
            }
            $data = [
                'categories' => $categories,
                'error' => isset($_GET['error']) ? $_GET['error'] : null,
                'success' => isset($_GET['success']) ? $_GET['success'] : null,
                'search_query' => $query
            ];
            $this->view('categories/categories', $data);
        } catch (Exception $e) {
            $data = [
                'error' => $e->getMessage(),
                'categories' => [],
                'search_query' => $query
            ];
            $this->view('categories/categories', $data);
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = trim($_POST['category_name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $product_ids = $_POST['product_ids'] ?? [];

            if (empty($category_name)) {
                header('Location: /category/create?error=Category name is required');
                exit;
            }

            try {
                $category_id = $this->categoriesModel->createCategory($category_name, $description);
                if (!empty($product_ids)) {
                    $this->categoriesModel->assignProductsToCategory($category_id, $product_ids);
                }
                header('Location: /category?success=Category created successfully');
                exit;
            } catch (Exception $e) {
                header('Location: /category/create?error=' . urlencode($e->getMessage()));
                exit;
            }
        }

        try {
            $products = $this->categoriesModel->getAllProducts();
            $data = [
                'products' => $products,
                'error' => isset($_GET['error']) ? $_GET['error'] : null
            ];
            $this->view('categories/create', $data);
        } catch (Exception $e) {
            $data = [
                'products' => [],
                'error' => $e->getMessage()
            ];
            $this->view('categories/create', $data);
        }
    }

    public function edit($category_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = trim($_POST['category_name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $product_ids = $_POST['product_ids'] ?? [];

            if (empty($category_name)) {
                header('Location: /category/edit/' . $category_id . '?error=Category name is required');
                exit;
            }

            try {
                $this->categoriesModel->updateCategory($category_id, $category_name, $description);
                // Update product assignments
                $this->categoriesModel->assignProductsToCategory($category_id, $product_ids);
                header('Location: /category?success=Category updated successfully');
                exit;
            } catch (Exception $e) {
                header('Location: /category/edit/' . $category_id . '?error=' . urlencode($e->getMessage()));
                exit;
            }
        }

        try {
            $category = $this->categoriesModel->getCategoryById($category_id);
            if (!$category) {
                header('Location: /category?error=Category not found');
                exit;
            }
            $products = $this->categoriesModel->getAllProducts();
            $assigned_products = $this->categoriesModel->getProductsByCategory($category_id);
            $data = [
                'category' => $category,
                'products' => $products,
                'assigned_product_ids' => array_column($assigned_products, 'product_id'),
                'error' => isset($_GET['error']) ? $_GET['error'] : null
            ];
            $this->view('categories/edit', $data);
        } catch (Exception $e) {
            header('Location: /category?error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public function delete($category_id) {
        try {
            $category = $this->categoriesModel->getCategoryById($category_id);
            if (!$category) {
                header('Location: /category?error=Category not found');
                exit;
            }
            $this->categoriesModel->deleteCategory($category_id);
            header('Location: /category?success=Category deleted successfully');
            exit;
        } catch (Exception $e) {
            header('Location: /category?error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public function show($category_id) {
        try {
            $category = $this->categoriesModel->getCategoryById($category_id);
            if (!$category) {
                header('Location: /category?error=Category not found');
                exit;
            }
            $products = $this->categoriesModel->getProductsByCategory($category_id);
            $data = [
                'category' => $category,
                'products' => $products,
                'error' => isset($_GET['error']) ? $_GET['error'] : null
            ];
            $this->view('categories/view', $data);
        } catch (Exception $e) {
            header('Location: /category?error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}
?>