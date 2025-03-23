<?php
class UserModel
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = new Database("localhost", "vc1_db", "root", ""); // Adjust credentials
        } catch (Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getUsers()
    {
        try {
            $result = $this->db->query("SELECT * FROM users");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getUsers: " . $e->getMessage());
            return [];
        }
    }

    public function getUserById($user_id)
    {
        try {
            $result = $this->db->query("SELECT * FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getUserById: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($user_id, $first_name, $last_name, $email, $password, $role, $phone, $image = null)
    {
        try {
            $params = [
                ':user_id' => $user_id,
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':email' => strtolower($email),
                ':password' => password_hash($password, PASSWORD_DEFAULT),
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
            return true;
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($user_id)
    {
        try {
            $this->db->query("DELETE FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public function searchUsers($query)
    {
        try {
            $sql = "SELECT * FROM users WHERE first_name LIKE :query OR last_name LIKE :query OR email LIKE :query";
            $stmt = $this->db->query($sql, ['query' => '%' . $query . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in searchUsers: " . $e->getMessage());
            return [];
        }
    }

    public function getTotalUsers()
    {
        try {
            $result = $this->db->query("SELECT COUNT(*) as total FROM users");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getTotalUsers: " . $e->getMessage());
            return 0;
        }
    }

    public function getActiveUsers()
    {
        try {
            $result = $this->db->query(
                "SELECT COUNT(*) as total FROM users WHERE last_activity >= :time_threshold",
                [':time_threshold' => date('Y-m-d H:i:s', strtotime('-15 minutes'))]
            );
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getActiveUsers: " . $e->getMessage());
            return 0;
        }
    }

    public function getInactiveUsers()
    {
        try {
            $result = $this->db->query(
                "SELECT COUNT(*) as total FROM users WHERE last_activity < :time_threshold OR last_activity IS NULL",
                [':time_threshold' => date('Y-m-d H:i:s', strtotime('-15 minutes'))]
            );
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getInactiveUsers: " . $e->getMessage());
            return 0;
        }
    }

    public function updateLastActivity($user_id)
    {
        try {
            $this->db->query(
                "UPDATE users SET last_activity = NOW() WHERE user_id = :user_id",
                [':user_id' => $user_id]
            );
            return true;
        } catch (Exception $e) {
            error_log("Error in updateLastActivity: " . $e->getMessage());
            return false;
        }
    }

    public function addUser($first_name, $last_name, $email, $password, $role, $phone, $image = null)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($hashedPassword === false) {
            throw new Exception("Failed to hash password");
        }
        try {
            $this->db->query(
                "INSERT INTO users (first_name, last_name, email, password, role, phone, image, last_activity) 
                 VALUES (:first_name, :last_name, :email, :password, :role, :phone, :image, NOW())",
                [
                    ':first_name' => $first_name,
                    ':last_name' => $last_name,
                    ':email' => strtolower($email),
                    ':password' => $hashedPassword,
                    ':role' => $role,
                    ':phone' => $phone,
                    ':image' => $image
                ]
            );
            error_log("User added: $email with hashed password: $hashedPassword");
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                error_log("Duplicate email error: $email - " . $e->getMessage());
                throw new Exception("Email already exists in the database.");
            }
            error_log("Error adding user: " . $e->getMessage());
            throw $e;
        }
    }

    public function getUserByEmail($email)
    {
        try {
            $result = $this->db->query("SELECT * FROM users WHERE LOWER(email) = :email", [':email' => strtolower($email)]);
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getUserByEmail: " . $e->getMessage());
            return false;
        }
    }
}