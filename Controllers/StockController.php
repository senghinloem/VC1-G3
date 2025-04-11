<?php
require_once "Models/StockModel.php";

class StockController extends BaseController
{
    private $stockModel;

    public function __construct()
    {
        $this->stockModel = new StockModel();
    }

    public function stock()
    {
        $stock_management = $this->stockModel->getStock();
        $this->view("stocks/stock", ["stock_management" => $stock_management]);
    }

    public function create_stock()
    {
        $this->view("stocks/create_stock");
    }

    public function view_detail($stock_id)
    {
        $stock = $this->stockModel->getStockById($stock_id);
        if ($stock) {
            $this->view('stocks/view_stock', ['stock' => $stock]);
        } else {
            $this->redirect('/stock?error=Stock not found');
        }
    }

    public function store()
    {
        if (!isset($_POST['stock_name']) || empty(trim($_POST['stock_name']))) {
            $this->view("stocks/create_stock", ['error' => 'Stock name is required.']);
            return;
        }

        if (!isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
            $this->view("stocks/create_stock", ['error' => 'Valid quantity is required.']);
            return;
        }

        $stock_name = trim($_POST['stock_name']);
        $quantity = (int)$_POST['quantity'];

        try {
            $this->stockModel->addStock($stock_name, $quantity);
            $this->redirect('/stock?success=Stock added successfully');
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') { // Duplicate entry error
                $this->view("stocks/create_stock", ['error' => 'Stock already created.']);
            } else {
                $this->view("stocks/create_stock", ['error' => 'An error occurred while creating stock: ' . $e->getMessage()]);
            }
        }
    }

    public function destroy($stock_id)
    {
        try {
            $success = $this->stockModel->deleteStock($stock_id);
            if ($success) {
                $this->redirect('/stock?success=Stock deleted successfully');
            } else {
                $this->redirect('/stock?error=Stock not found');
            }
        } catch (Exception $e) {
            error_log("Delete error: " . $e->getMessage());
            $this->redirect('/stock?error=Failed to delete stock');
        }
    }

    public function search()
    {
        $search_term = $_GET['search'] ?? '';
        $stock_management = $this->stockModel->searchStock($search_term);
        $this->view("stocks/stock", ["stock_management" => $stock_management]);
    }

    public function edit($stock_id)
    {
        $stock = $this->stockModel->getStockById($stock_id);
        if ($stock) {
            $this->view('stocks/edit', ['stock' => $stock]);
        } else {
            $this->redirect('/stock?error=Stock not found');
        }
    }

    public function update($stock_id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/stock/edit/' . $stock_id);
            return;
        }

        if (!isset($_POST['stock_name']) || empty(trim($_POST['stock_name']))) {
            $stock = $this->stockModel->getStockById($stock_id);
            $this->view("stocks/edit", [
                'error' => 'Stock name is required.',
                'stock' => $stock ?? ['stock_id' => $stock_id]
            ]);
            return;
        }

        if (!isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
            $stock = $this->stockModel->getStockById($stock_id);
            $this->view("stocks/edit", [
                'error' => 'Valid quantity is required.',
                'stock' => $stock ?? ['stock_id' => $stock_id]
            ]);
            return;
        }

        $stock_name = trim($_POST['stock_name']);
        $quantity = (int)$_POST['quantity'];

        try {
            $success = $this->stockModel->updateStock($stock_id, $stock_name, $quantity);
            if ($success) {
                $this->redirect('/stock?success=Stock updated successfully');
            } else {
                throw new Exception("Update failed");
            }
        } catch (Exception $e) {
            $this->view("stocks/edit", [
                'error' => 'An error occurred while updating the stock item.',
                'stock' => [
                    'stock_id' => $stock_id,
                    'stock_name' => $stock_name,
                    'quantity' => $quantity
                ]
            ]);
        }
    }

    public function adjust($stock_id)
    {
        $stock = $this->stockModel->getStockById($stock_id);
        if (!$stock) {
            $this->redirect("/stock?error=Stock not found.");
            return;
        }

        $add = isset($_POST['add_quantity']) ? (int) $_POST['add_quantity'] : 0;
        $subtract = isset($_POST['subtract_quantity']) ? (int) $_POST['subtract_quantity'] : 0;

        $new_quantity = max(0, $stock['quantity'] + $add - $subtract); // Avoid negative values

        try {
            $this->stockModel->updateStock($stock_id, $stock['stock_name'], $new_quantity);
            $this->redirect("/stock/view/{$stock_id}?success=Stock updated successfully.");
        } catch (Exception $e) {
            error_log("Adjustment error: " . $e->getMessage());
            $this->redirect("/stock/view/{$stock_id}?error=Failed to adjust stock.");
        }
    }
}