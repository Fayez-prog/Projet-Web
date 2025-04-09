<?php
require_once 'config.php';

class Auth {
    private $db;
    
    public function __construct() {
        $this->db = getDBConnection();
    }
    
    // Register a new user
    public function register($name, $email, $password, $role, $actorData = null) {
        // Check if email exists
        $stmt = $this->db->prepare("SELECT id FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return false; // Email already exists
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $this->db->beginTransaction();
            
            // Insert into Users table
            $stmt = $this->db->prepare("INSERT INTO Users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword, $role]);
            $userId = $this->db->lastInsertId();
            
            // If actor, insert into Actors table
            if ($role === 'actor' && $actorData) {
                $stmt = $this->db->prepare("INSERT INTO Actors (user_id, birth_date, nationality) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $actorData['birth_date'], $actorData['nationality']]);
            }
            
            $this->db->commit();
            return $userId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    // Login user
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT id, name, email, password, role FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        }
        return false;
    }
    
    // Check if user is logged in
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Get current user role
    public static function getUserRole() {
        return $_SESSION['user_role'] ?? null;
    }
    
    // Get current user ID
    public static function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    // Logout user
    public function logout() {
        session_destroy();
    }
}
?>