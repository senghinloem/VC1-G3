<?php
class UserModel
{
    private $db;

    public function __construct()
    {
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

    public function addUser($first_name, $last_name, $email, $password, $role, $phone, $image = null)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $this->db->query(
                "INSERT INTO users (first_name, last_name, email, password, role, phone, image) 
                 VALUES (:first_name, :last_name, :email, :password, :role, :phone, :image)",
                [
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':role' => $role,
                    ':phone' => $phone,
                    ':image' => $image
                ]
            );
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
            exit();
        }
    }

    public function updateUser($user_id, $first_name, $last_name, $email, $password, $role, $phone, $image = null)
    {
        try {
            $params = [
                ':user_id' => $user_id,
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':email' => $email,
                ':password' => $password,
                ':role' => $role,
                ':phone' => $phone
            ];
            
            $sql = "UPDATE users 
                    SET first_name = :first_name, 
                        last_name = :last_name, 
                        email = :email, 
                        password = :password, 
                        role = :role, 
                        phone = :phone";
            
            if ($image !== null) {
                $sql .= ", image = :image";
                $params[':image'] = $image;
            }
            
            $sql .= " WHERE user_id = :user_id";
            
            $this->db->query($sql, $params);
        } catch (PDOException $e) {
            echo "Error updating user: " . $e->getMessage();
            exit();
        }
    }

    public function deleteUser($user_id)
    {
        try {
            $this->db->query("DELETE FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
            exit();
        }
    }

    public function searchUsers($query)
    {
        $sql = "SELECT * FROM users WHERE first_name LIKE :query OR last_name LIKE :query OR email LIKE :query";
        $stmt = $this->db->query($sql, ['query' => '%' . $query . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
{
    $result = $this->db->query("SELECT * FROM users WHERE email = :email", [':email' => $email]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

}