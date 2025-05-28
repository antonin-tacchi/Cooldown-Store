<?php

// Détection automatique de l'environnement
$isDocker = file_exists('/.dockerenv') || gethostname() === 'cooldown_web';

// Configuration de la base de données
if ($isDocker) {
    // Configuration Docker
    define('DB_HOST', 'mysql');
    define('DB_PASS', 'root');
    define('SITE_URL', 'http://localhost:8083');
} else {
    // Configuration WAMP
    define('DB_HOST', 'localhost');
    define('DB_PASS', '');
    define('SITE_URL', 'http://localhost/cooldown-store');
}

define('DB_NAME', 'cooldown_store');
define('DB_USER', 'root');

// Configuration du site
define('SITE_NAME', 'Cooldown Store');

// Configuration des emails
define('EMAIL_FROM', 'noreply@cooldown-store.com');
define('EMAIL_NAME', 'Cooldown Store');

// Options de développement
define('DEBUG', true);