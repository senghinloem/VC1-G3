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
        $result = $this->db->query("SELECT stock_id, quantity, stock_type, last_updated FROM stock_management");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addStock($stockName, $quantity)
    {
        $stmt = $this->db->query("INSERT INTO stocks (stock_name, quantity) VALUES (:stock_name, :quantity)");
        $stmt->bindParam(':stock_name', $stockName, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function updateStock($stock, $stockName, $quantity)
    {
        $stmt = $this->db->query("UPDATE stocks SET stock_name = :stock_name, quantity = :quantity WHERE stock_id = :stock_id");
        $stmt->bindParam(':stock_name', $stockName, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':stock_id', $stock, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function deleteStock($stockId)
    {
        $stmt = $this->db->query("DELETE FROM stocks WHERE stock_id = :stock_id");
        $stmt->bindParam(':stock_id', $stockId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    // public function searchStock($query)
    // {
    //     $stmt = $this->db->query("SELECT * FROM stocks WHERE stock_name LIKE :query");
    //     $stmt->bindValue(':query', '%'.$query.'%', PDO::PARAM_STR);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
}
