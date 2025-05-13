<?php

class Session {
    // Démarrer la session
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    // Définir un message flash
    public static function setFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    // Récupérer et effacer un message flash
    public static function getFlash() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        
        return null;
    }
    
    // Vérifier si un message flash existe
    public static function hasFlash() {
        return isset($_SESSION['flash']);
    }
    
    // Détruire la session
    public static function destroy() {
        // Vider le tableau de session
        $_SESSION = [];
        
        // Détruire le cookie de session
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        
        // Détruire la session
        session_destroy();
    }
}