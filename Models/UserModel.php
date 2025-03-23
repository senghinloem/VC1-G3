<?php
class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    // Get total number of users
    public function getTotalUsers()
    {
        $result = $this->db->query("SELECT COUNT(*) as total FROM users");
        return $result->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    // Get total number of active users
    public function getActiveUsers()
    {
        $result = $this->db->query("SELECT COUNT(*) as total FROM users WHERE status = 1");
        return $result->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    // Get total number of inactive users
    public function getInactiveUsers()
    {
        $result = $this->db->query("SELECT COUNT(*) as total FROM users WHERE status = 0");
        return $result->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    // Get total number of admin users
    public function getAdminUsers()
    {
        $result = $this->db->query("SELECT COUNT(*) as total FROM users WHERE role = 'Admin'");
        return $result->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    // Get users with pagination
    public function getUsers($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM users LIMIT :offset, :perPage";
        $result = $this->db->query($sql, [':offset' => $offset, ':perPage' => $perPage]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search users with pagination
    public function searchUsers($query, $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM users 
                WHERE first_name LIKE :query OR last_name LIKE :query OR email LIKE :query 
                LIMIT :offset, :perPage";
        $stmt = $this->db->query($sql, [
            ':query' => '%' . $query . '%',
            ':offset' => $offset,
            ':perPage' => $perPage
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get total number of users matching the search query
    public function getSearchUsersCount($query)
    {
        $sql = "SELECT COUNT(*) as total FROM users 
                WHERE first_name LIKE :query OR last_name LIKE :query OR email LIKE :query";
        $stmt = $this->db->query($sql, [':query' => '%' . $query . '%']);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    public function getUserById($user_id)
    {
        $result = $this->db->query("SELECT * FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($first_name, $last_name, $email, $password, $role, $phone, $image = null, $status = 1)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $this->db->query(
                "INSERT INTO users (first_name, last_name, email, password, role, phone, image, status) 
                 VALUES (:first_name, :last_name, :email, :password, :role, :phone, :image, :status)",
                [
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':email' => $email,
                    ':password' => $hashedPassword,
                    ':role' => $role,
                    ':phone' => $phone,
                    ':image' => $image,
                    ':status' => $status
                ]
            );
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
            exit();
        }
    }

    public function updateUser($user_id, $first_name, $last_name, $email, $password, $role, $phone, $image = null, $status = null)
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
            
            if ($status !== null) {
                $sql .= ", status = :status";
                $params[':status'] = $status;
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

    public function getUserByEmail($email)
    {
        $result = $this->db->query("SELECT * FROM users WHERE email = :email", [':email' => $email]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}