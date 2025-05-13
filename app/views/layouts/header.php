<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cooldown Store</title>
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <script defer src="./public/assets/js/scripts.js"></script>
    <script defer src="./public/assets/js/cart.js"></script>
    <script defer src="./public/assets/js/search.js"></script>
</head>
<body>
    <div class="header">
        <div class="logo">
            <div class="logo-image">
                <!-- Lien vers la page d'accueil -->
                <a href="index.php"><img class="logo-image" src="./public/assets/image/logo-Cooldown.png" alt="Logo Cooldown Store"></a>
            </div>
        </div>
        
        <div class="nav-center">
            <div class="nav-links">
                <!-- Liens vers les catégories avec le contrôleur product et l'action list -->
                <a href="?controller=product&action=list&category=1" class="nav-item">PC</a>
                <a href="?controller=product&action=list&category=2" class="nav-item">Xbox</a>
                <a href="?controller=product&action=list&category=3" class="nav-item">PlayStation</a>
                <a href="?controller=product&action=list&category=4" class="nav-item">Nintendo</a>
            </div>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="Rechercher...">
                <div class="search-button">
                    <!-- SVG de la loupe -->
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="white" d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                </div>
            </div>
        </div>

        
        <div class="nav-right">
            <!-- Icône panier avec lien vers le panier -->
            <a href="?controller=cart&action=view"><img id="cart-toggle" class="cart-icon" src="./public/assets/image/caddie.png" alt="Caddie.png"></a>
            
            <!-- Icône utilisateur avec lien conditionnel selon connexion -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="?controller=user&action=profile"><img class="user-icon" src="./public/assets/image/user.png" alt="user.png"></a>
            <?php else: ?>
                <a href="?controller=user&action=login"><img class="user-icon" src="./public/assets/image/user.png" alt="user.png"></a>
            <?php endif; ?>
        </div>

        <!-- Burger pour mobile -->
        <div class="burger-menu" id="burger-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Overlay -->
        <div class="overlay" id="mobile-overlay"></div>

        <!-- Menu mobile -->
        <div class="mobile-nav" id="mobile-nav">
            <div class="mobile-header">
                <span>Menu</span>
                <button id="close-mobile-nav">&times;</button>
            </div>
            <!-- Mêmes liens dans le menu mobile -->
            <a href="?controller=product&action=list&category=1" class="nav-item">PC</a>
            <a href="?controller=product&action=list&category=2" class="nav-item">Xbox</a>
            <a href="?controller=product&action=list&category=3" class="nav-item">PlayStation</a>
            <a href="?controller=product&action=list&category=4" class="nav-item">Nintendo</a>
            
            <!-- Ajout des liens utilisateur et panier pour accès facile -->
            <a href="?controller=cart&action=view" class="nav-item">Mon panier</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="?controller=user&action=profile" class="nav-item">Mon profil</a>
                <a href="?controller=user&action=logout" class="nav-item">Déconnexion</a>
            <?php else: ?>
                <a href="?controller=user&action=login" class="nav-item">Connexion</a>
                <a href="?controller=user&action=register" class="nav-item">Inscription</a>
            <?php endif; ?>
        </div>
    </div>