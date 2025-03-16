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
        $result = $this->db->query("SELECT stock_id, stock_name FROM stock_management");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addStock($quantity, $stock_type)
    {
        $result = $this->db->query("INSERT INTO stock_management (quantity, stock_type) VALUES (:quantity, :stock_type)", [
            'quantity' => $quantity,
            'stock_type' => $stock_type
        ]);
        return $result;
    }

    public function getStockById($stock_id)
    {
        $result = $this->db->query("SELECT * FROM stock_management WHERE stock_id = :stock_id", [
            'stock_id' => $stock_id
        ]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }


    public function updateStock($stock_id, $quantity, $stock_type)
    {
        $result = $this->db->query(
            "UPDATE stock_management 
             SET quantity = :quantity, stock_type = :stock_type
             WHERE stock_id = :stock_id",
            [
                'stock_id' => $stock_id,
                'quantity' => $quantity,
                'stock_type' => $stock_type
            ]
        );
        return $result;
    }

    public function deleteStock($stock_id)
    {
        $result = $this->db->query("DELETE FROM stock_management WHERE stock_id = :stock_id", [
            'stock_id' => $stock_id
        ]);
        return $result;
    }
}
?>
