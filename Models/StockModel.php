<?php
class StockModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getStock()
    {
        $result = $this->db->query("SELECT * FROM stock_management");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }


    public function view_stock($stock_id)
    {
        // Fetch the stock details from the database
        $stock = $this->getStockById($stock_id);

        if ($stock) {
            return $stock;
        } else {
            // Handle the case if no stock is found
            return false; // Or return some other indication
        }
    }

    public function getStockById($stock_id)
    {
        $result = $this->db->query("SELECT * FROM stock_management WHERE stock_id = :stock_id", ["stock_id" => $stock_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addStock($stock_name)
    {
        $sql = "INSERT INTO stock_management (stock_name, last_updated) VALUES (:stock_name, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateStock($stock_id, $stock_name)
    {
        $sql = "UPDATE stock_management SET stock_name = :stock_name, last_updated = NOW() WHERE stock_id = :stock_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
        $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteStock($stock_id)
    {
        $sql = "DELETE FROM stock_management WHERE stock_id = :stock_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
