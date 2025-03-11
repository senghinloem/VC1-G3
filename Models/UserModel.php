
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

    public function getUserById($user_id)
    {
        $result = $this->db->query("SELECT * FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($first_name, $last_name, $email, $password, $role, $phone)
    {
        try {
            $this->db->query(
                "INSERT INTO users (first_name, last_name, email, password, role, phone) VALUES (:first_name, :last_name, :email, :password, :role, :phone)",
                [
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':email' => $email,
                    ':password' => $password,
                    ':role' => $role,
                    ':phone' => $phone
                ]
            );
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
        }
    }
    
    public function updateUser($user_id, $first_name, $last_name, $email, $password, $role, $phone)
    {
        try {
            $this->db->query(
                "UPDATE users 
                 SET first_name = :first_name, last_name = :last_name, email = :email, 
                     password = :password, role = :role, phone = :phone 
                 WHERE user_id = :user_id",
                [
                    ':user_id' => $user_id,
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':email' => $email,
                    ':password' => $password,
                    ':role' => $role,
                    ':phone' => $phone
                ]
            );
        } catch (PDOException $e) {
            echo "Error updating user: " . $e->getMessage();
        }
    }

    public function deleteUser($user_id)
{
    try {
        $this->db->query("DELETE FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
    } catch (PDOException $e) {
        echo "Error deleting user: " . $e->getMessage();
    }
}

public function getUserByEmail($email) {
    $result = $this->db->query("SELECT * FROM users WHERE email = :email", ['email' => $email]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

    

    
}

?>