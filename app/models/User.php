<?php

class User {
    private $db;
    
    public function __construct() {
        require_once 'config/config.php';
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 
            DB_USER, 
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    
    // Récupérer un utilisateur par ID
    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Récupérer un utilisateur par email
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Créer un nouvel utilisateur
    public function createUser($data) {
        $sql = "INSERT INTO users (name, email, password, role, created_at) 
                VALUES (:name, :email, :password, :role, NOW())";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':role', $data['role']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }
    
    // Mettre à jour un utilisateur
    public function updateUser($id, $data) {
        $sql = "UPDATE users SET name = :name, email = :email";
        
        // Ajouter le mot de passe s'il est fourni
        if (isset($data['password'])) {
            $sql .= ", password = :password";
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        
        if (isset($data['password'])) {
            $stmt->bindParam(':password', $data['password']);
        }
        
        return $stmt->execute();
    }
    
    // Récupérer tous les utilisateurs (pour l'admin)
    public function getAllUsers() {
        $sql = "SELECT id, name, email, role, created_at FROM users ORDER BY name";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Supprimer un utilisateur
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}   