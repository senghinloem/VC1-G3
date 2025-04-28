<?php
class Database
{
    private $pdo;

    public function __construct($host, $dbname, $username, $password)
    {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            throw $e;
        }
    }

    public function prepare($sql)
    {
        try {
            return $this->pdo->prepare($sql);
        } catch (PDOException $e) {
            error_log("Prepare error: " . $e->getMessage());
            throw $e;
        }
    }

    public function beginTransaction()
    {
        try {
            return $this->pdo->beginTransaction();
        } catch (PDOException $e) {
            error_log("Begin transaction error: " . $e->getMessage());
            throw $e;
        }
    }

    public function commit()
    {
        try {
            return $this->pdo->commit();
        } catch (PDOException $e) {
            error_log("Commit error: " . $e->getMessage());
            throw $e;
        }
    }

    public function rollBack()
    {
        try {
            return $this->pdo->rollBack();
        } catch (PDOException $e) {
            error_log("Rollback error: " . $e->getMessage());
            throw $e;
        }
    }

    public function lastInsertId()
    {
        try {
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("lastInsertId error: " . $e->getMessage());
            throw $e;
        }
    }
}