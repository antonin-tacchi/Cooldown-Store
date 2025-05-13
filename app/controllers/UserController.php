<?php

class UserController {
    private $userModel;
    
    public function __construct() {
        require_once 'app/models/User.php';
        require_once 'core/Session.php';
        require_once 'core/Auth.php';
        
        $this->userModel = new User();
        Session::start();
    }
    
    // Afficher le formulaire de connexion
    public function login() {
        // Rediriger si déjà connecté
        if (Auth::isLoggedIn()) {
            header('Location: index.php');
            exit;
        }
        
        // Récupérer l'URL de redirection après connexion
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';
        
        // Charger la vue
        require_once 'app/views/user/login.php';
    }
    
    // Traiter la connexion
    public function doLogin() {
        // Vérifier les données
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            header('Location: ?controller=user&action=login&error=missing_fields');
            exit;
        }
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Vérifier l'authentification
        if (Auth::login($email, $password)) {
            // Redirection après connexion
            $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : '';
            
            if ($redirect === 'checkout') {
                header('Location: ?controller=cart&action=checkout');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            // Échec de connexion
            header('Location: ?controller=user&action=login&error=invalid_credentials');
            exit;
        }
    }
    
    // Déconnexion
    public function logout() {
        Auth::logout();
        header('Location: index.php');
        exit;
    }
    
    // Afficher le formulaire d'inscription
    public function register() {
        // Rediriger si déjà connecté
        if (Auth::isLoggedIn()) {
            header('Location: index.php');
            exit;
        }
        
        // Charger la vue
        require_once 'app/views/user/register.php';
    }
    
    // Traiter l'inscription
    public function doRegister() {
        // Vérifier les données
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password_confirm'])) {
            header('Location: ?controller=user&action=register&error=missing_fields');
            exit;
        }
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['password_confirm'];
        
        // Vérifier si les mots de passe correspondent
        if ($password !== $passwordConfirm) {
            header('Location: ?controller=user&action=register&error=password_mismatch');
            exit;
        }
        
        // Vérifier si l'email est déjà utilisé
        if ($this->userModel->getUserByEmail($email)) {
            header('Location: ?controller=user&action=register&error=email_exists');
            exit;
        }
        
        // Créer l'utilisateur
        $userId = $this->userModel->createUser([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user'
        ]);
        
        if ($userId) {
            // Connecter l'utilisateur
            Auth::loginById($userId);
            header('Location: index.php');
            exit;
        } else {
            header('Location: ?controller=user&action=register&error=registration_failed');
            exit;
        }
    }
    
    // Afficher le profil utilisateur
    public function profile() {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::isLoggedIn()) {
            header('Location: ?controller=user&action=login&redirect=profile');
            exit;
        }
        
        // Récupérer les infos de l'utilisateur
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        // Charger la vue
        require_once 'app/views/user/profile.php';
    }
    
    // Mettre à jour le profil
    public function updateProfile() {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::isLoggedIn()) {
            header('Location: ?controller=user&action=login');
            exit;
        }
        
        // Vérifier les données
        if (!isset($_POST['name']) || !isset($_POST['email'])) {
            header('Location: ?controller=user&action=profile&error=missing_fields');
            exit;
        }
        
        $userId = $_SESSION['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        
        // Vérifier si l'email est déjà utilisé par un autre utilisateur
        $existingUser = $this->userModel->getUserByEmail($email);
        if ($existingUser && $existingUser['id'] !== $userId) {
            header('Location: ?controller=user&action=profile&error=email_exists');
            exit;
        }
        
        // Mettre à jour l'utilisateur
        $result = $this->userModel->updateUser($userId, [
            'name' => $name,
            'email' => $email
        ]);
        
        if ($result) {
            header('Location: ?controller=user&action=profile&success=profile_updated');
        } else {
            header('Location: ?controller=user&action=profile&error=update_failed');
        }
        exit;
    }
    
    // Afficher les commandes de l'utilisateur
    public function orders() {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::isLoggedIn()) {
            header('Location: ?controller=user&action=login&redirect=orders');
            exit;
        }
        
        // Charger le modèle Order
        require_once 'app/models/Order.php';
        $orderModel = new Order();
        
        // Récupérer les commandes de l'utilisateur
        $orders = $orderModel->getOrdersByUserId($_SESSION['user_id']);
        
        // Charger la vue
        require_once 'app/views/user/orders.php';
    }
}