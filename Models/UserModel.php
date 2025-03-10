
<?php

class UserModel
{
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function getUsers()
    {
        $result = $this->db->query("SELECT * FROM users");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $result = $this->db->query("SELECT * FROM users WHERE id = :id", [':id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($name, $email, $password, $role)
    {
        try {
            $this->db->query(
                "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)",
                [
                    ':name' => $name,
                    ':email'=> $email,
                    ':password' => $password,
                    ':role' => $role,
                ]
            );
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
        }
    }

    public function updateUser($id, $name, $email, $password, $role)
    {
        try {
            $this->db->query(
                "UPDATE users SET name = :name, email = :email, password = :password, role = :role WHERE id = :id",
                [
                    ':name' => $name,
                    ':email' => $email,
                    ':password' => $password,
                    ':role' => $role,
                    ':id' => $id
                ]
            );
        } catch (PDOException $e) {
            echo "Error updating user: " . $e->getMessage();
        }
    }

    public function deleteUser ($id) {
        try {
            $this->db->query("DELETE FROM users WHERE id = :id", [':id' => $id]);
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
        }
    }
}

?>