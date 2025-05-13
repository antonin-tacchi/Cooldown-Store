<?php
// Point d'entrée de l'application

// Chemin absolu vers le répertoire racine du projet
define('ROOT_PATH', __DIR__);

// Charger les classes de base
require_once ROOT_PATH . '/core/Router.php';
require_once ROOT_PATH . '/core/Session.php';

// Démarrer la session
Session::start();

// Initialiser le routeur
$router = new Router();

// Traiter la requête
$router->route();
?>