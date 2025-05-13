<?php

class Router {
    private $controller;
    private $action;
    private $routes;
    
    public function __construct() {
        // Charger les routes
        require_once 'config/routes.php';
        $this->routes = $routes;
        
        // Récupérer le contrôleur et l'action depuis l'URL
        $this->controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'index';
    }
    
    public function route() {
        // Vérifier si la route existe
        if (!isset($this->routes[$this->controller][$this->action])) {
            // Route non trouvée, rediriger vers la page d'accueil
            header('Location: index.php');
            exit;
        }
        
        // Récupérer le contrôleur et l'action à exécuter
        $controllerName = ucfirst($this->controller) . 'Controller';
        $actionName = $this->action;
        
        // Vérifier si le fichier du contrôleur existe
        $controllerFile = 'app/controllers/' . $controllerName . '.php';
        
        if (!file_exists($controllerFile)) {
            // Contrôleur non trouvé, rediriger vers la page d'accueil
            header('Location: index.php');
            exit;
        }
        
        // Charger le contrôleur
        require_once $controllerFile;
        
        // Créer une instance du contrôleur et exécuter l'action
        $controller = new $controllerName();
        
        if (!method_exists($controller, $actionName)) {
            // Action non trouvée, rediriger vers la page d'accueil
            header('Location: index.php');
            exit;
        }
        
        // Exécuter l'action
        $controller->$actionName();
    }
}