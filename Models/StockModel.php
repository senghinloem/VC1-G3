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

    public function addStock($stock_name)
    {
        $result = $this->db->query("INSERT INTO stock_management (stock_name) VALUES (:stock_name)", [
            'stock_name' => $stock_name
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

        $result = $this->db->query("SELECT * FROM stock_management");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStockById($stock_id)
    {
        $result = $this->db->query("SELECT * FROM stock_management WHERE stock_id = :stock_id", ["stock_id" => $stock_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addStock($stock_name)
    {
        $sql = "INSERT INTO stock_management (stock_name) VALUES (:stock_name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stock_name', $stock_name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateStock($stock_id, $stock_name)
    {
        $sql = "UPDATE stock_management SET stock_name = :stock_name WHERE stock_id = :stock_id";
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
