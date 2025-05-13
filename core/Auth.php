<?php

class Auth {
    // Vérifier si l'utilisateur est connecté
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Vérifier si l'utilisateur est admin
    public static function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
    
    // Connecter un utilisateur par email/mot de passe
    public static function login($email, $password) {
        require_once 'app/models/User.php';
        $userModel = new User();
        
        $user = $userModel->getUserByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            // Stocker les infos en session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            return true;
        }
        
        return false;
    }
    
    // Connecter un utilisateur par ID (après inscription)
    public static function loginById($userId) {
        require_once 'app/models/User.php';
        $userModel = new User();
        
        $user = $userModel->getUserById($userId);
        
        if ($user) {
            // Stocker les infos en session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            return true;
        }
        
        return false;
    }
    
    // Déconnecter l'utilisateur
    public static function logout() {
        // Supprimer les variables de session
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_role']);
        
        // Régénérer l'ID de session
        session_regenerate_id(true);
    }
    
    // Vérifier les autorisations admin
    public static function requireAdmin() {
        if (!self::isLoggedIn() || !self::isAdmin()) {
            header('Location: index.php');
            exit;
        }
    }
}