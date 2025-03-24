<?php

class UserModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new Database("localhost", "vc1_db", "root", "");
            if ($this->db instanceof Database) {
                $this->db->query("SET time_zone = '+00:00'");
            }
        } catch (Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getUsers() {
        try {
            $result = $this->db->query("SELECT * FROM users");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getUsers: " . $e->getMessage());
            return [];
        }
    }

    public function getUserById($user_id) {
        try {
            $result = $this->db->query("SELECT * FROM users WHERE user_id = :user_id", [':user_id' => $user_id]);
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getUserById: " . $e->getMessage());
            return false;
        }
    }

    public function addUser($first_name, $last_name, $email, $password, $role, $phone, $image = null) {
        $options = ['cost' => 12];
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID, $options);
        try {
            $this->db->query(
                "INSERT INTO users (first_name, last_name, email, password, role, phone, image, created_at, status, last_activity) 
                 VALUES (:first_name, :last_name, :email, :password, :role, :phone, :image, NOW(), 1, NOW())",
                [
                    ':first_name' => filter_var($first_name, FILTER_SANITIZE_STRING),
                    ':last_name' => filter_var($last_name, FILTER_SANITIZE_STRING),
                    ':email' => filter_var($email, FILTER_SANITIZE_EMAIL),
                    ':password' => $hashedPassword,
                    ':role' => filter_var($role, FILTER_SANITIZE_STRING),
                    ':phone' => filter_var($phone, FILTER_SANITIZE_STRING),
                    ':image' => $image
                ]
            );
            return true;
        } catch (PDOException $e) {
            error_log("Error adding user: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($user_id, $first_name, $last_name, $email, $password, $role, $phone, $image = null) {
        try {
            $params = [
                ':user_id' => filter_var($user_id, FILTER_SANITIZE_NUMBER_INT),
                ':first_name' => filter_var($first_name, FILTER_SANITIZE_STRING),
                ':last_name' => filter_var($last_name, FILTER_SANITIZE_STRING),
                ':email' => filter_var($email, FILTER_SANITIZE_EMAIL),
                ':password' => $password,
                ':role' => filter_var($role, FILTER_SANITIZE_STRING),
                ':phone' => filter_var($phone, FILTER_SANITIZE_STRING)
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

    public function deleteUser($user_id) {
        try {
            $this->db->query("DELETE FROM users WHERE user_id = :user_id", [':user_id' => filter_var($user_id, FILTER_SANITIZE_NUMBER_INT)]);
            return true;
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            return false;
        }
    }

    public function searchUsers($query) {
        try {
            $sql = "SELECT * FROM users WHERE first_name LIKE :query OR last_name LIKE :query OR email LIKE :query";
            $stmt = $this->db->query($sql, ['query' => '%' . filter_var($query, FILTER_SANITIZE_STRING) . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in searchUsers: " . $e->getMessage());
            return [];
        }
    }

    public function getUserByEmail($email) {
        try {
            $result = $this->db->query("SELECT * FROM users WHERE email = :email", [':email' => filter_var($email, FILTER_SANITIZE_EMAIL)]);
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getUserByEmail: " . $e->getMessage());
            return false;
        }
    }

    public function getTotalUsers() {
        try {
            $result = $this->db->query("SELECT COUNT(*) as total FROM users");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } catch (Exception $e) {
            error_log("Error in getTotalUsers: " . $e->getMessage());
            return 0;
        }
    }

    public function getActiveUsers() {
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

    public function getInactiveUsers() {
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

    public function updateLastActivity($user_id) {
        try {
            $this->db->query(
                "UPDATE users SET last_activity = NOW() WHERE user_id = :user_id",
                [':user_id' => filter_var($user_id, FILTER_SANITIZE_NUMBER_INT)]
            );
            return true;
        } catch (Exception $e) {
            error_log("Error in updateLastActivity: " . $e->getMessage());
            return false;
        }
    }

    public function recordLoginAttempt($email) {
        try {
            $this->db->query(
                "INSERT INTO login_attempts (email, attempt_time) 
                 VALUES (:email, NOW())",
                [':email' => filter_var($email, FILTER_SANITIZE_EMAIL)]
            );
        } catch (Exception $e) {
            error_log("Error recording login attempt: " . $e->getMessage());
        }
    }

    public function checkAccountLockout($email) {
        try {
            // Check if the account is already locked
            $userResult = $this->db->query(
                "SELECT locked FROM users WHERE email = :email",
                [':email' => filter_var($email, FILTER_SANITIZE_EMAIL)]
            );
            $user = $userResult->fetch(PDO::FETCH_ASSOC);
            if ($user && $user['locked'] == 1) {
                return true;
            }

            // Check login attempts
            $result = $this->db->query(
                "SELECT COUNT(*) as attempts 
                 FROM login_attempts 
                 WHERE email = :email 
                 AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE)",
                [':email' => filter_var($email, FILTER_SANITIZE_EMAIL)]
            );
            $count = $result->fetch(PDO::FETCH_ASSOC)['attempts'];
            if ($count >= 5) {
                // Lock the account
                $this->db->query(
                    "UPDATE users SET locked = 1 WHERE email = :email",
                    [':email' => filter_var($email, FILTER_SANITIZE_EMAIL)]
                );
                return true;
            }
            return false;
        } catch (Exception $e) {
            error_log("Error checking lockout: " . $e->getMessage());
            return false;
        }
    }

    public function updateFailedAttempts($user_id, $increment = true) {
        try {
            $sql = $increment 
                ? "UPDATE users SET failed_attempts = failed_attempts + 1, last_failed_attempt = NOW() WHERE user_id = :user_id"
                : "UPDATE users SET failed_attempts = 0, locked = 0 WHERE user_id = :user_id";
            
            $this->db->query($sql, [':user_id' => filter_var($user_id, FILTER_SANITIZE_NUMBER_INT)]);
            return true;
        } catch (Exception $e) {
            error_log("Error updating failed attempts: " . $e->getMessage());
            return false;
        }
    }

    public function createPasswordResetToken($email) {
        try {
            $user = $this->getUserByEmail($email);
            if (!$user) {
                return false;
            }

            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $this->db->query(
                "INSERT INTO password_resets (user_id, token, expires_at) 
                 VALUES (:user_id, :token, :expires_at)
                 ON DUPLICATE KEY UPDATE token = :token, expires_at = :expires_at",
                [
                    ':user_id' => $user['user_id'],
                    ':token' => $token,
                    ':expires_at' => $expires
                ]
            );

            return $token;
        } catch (Exception $e) {
            error_log("Error in createPasswordResetToken: " . $e->getMessage());
            return false;
        }
    }

    public function verifyResetToken($token) {
        try {
            $result = $this->db->query(
                "SELECT * FROM password_resets 
                 WHERE token = :token 
                 AND expires_at > NOW()",
                [':token' => $token]
            );
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in verifyResetToken: " . $e->getMessage());
            return false;
        }
    }

    public function resetPassword($token, $newPassword) {
        try {
            $reset = $this->verifyResetToken($token);
            if (!$reset) {
                return false;
            }

            $options = ['cost' => 12];
            $hashedPassword = password_hash($newPassword, PASSWORD_ARGON2ID, $options);

            $this->db->query(
                "UPDATE users 
                 SET password = :password 
                 WHERE user_id = :user_id",
                [
                    ':password' => $hashedPassword,
                    ':user_id' => $reset['user_id']
                ]
            );

            $this->db->query(
                "DELETE FROM password_resets 
                 WHERE token = :token",
                [':token' => $token]
            );

            return true;
        } catch (Exception $e) {
            error_log("Error in resetPassword: " . $e->getMessage());
            return false;
        }
    }
}
?>