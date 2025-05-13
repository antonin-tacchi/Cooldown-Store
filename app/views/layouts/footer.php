<footer class="footer">
    <div class="footer-container">
        <div class="footer-columns">
            <div class="footer-column">
                <h3>À propos</h3>
                <ul>
                    <!-- Liens vers des pages statiques (à créer) -->
                    <li><a href="?controller=page&action=about">Notre histoire</a></li>
                    <li><a href="?controller=page&action=blog">Blog</a></li>
                    <li><a href="?controller=page&action=careers">Carrières</a></li>
                    <li><a href="?controller=page&action=legal">Mentions légales</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Service client</h3>
                <ul>
                    <!-- Liens vers des pages de support -->
                    <li><a href="?controller=page&action=faq">Aide & FAQ</a></li>
                    <li><a href="?controller=page&action=shipping">Livraison</a></li>
                    <li><a href="?controller=page&action=returns">Retours</a></li>
                    <li><a href="?controller=page&action=contact">Nous contacter</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Catégories</h3>
                <ul>
                    <!-- Liens vers les catégories, similaires au header -->
                    <li><a href="?controller=product&action=list&category=1">Jeux PC</a></li>
                    <li><a href="?controller=product&action=list&category=2">Jeux Xbox</a></li>
                    <li><a href="?controller=product&action=list&category=3">Jeux PlayStation</a></li>
                    <li><a href="?controller=product&action=list&category=4">Jeux Nintendo</a></li>
                </ul>
            </div>
            
            <div class="footer-column newsletter">
                <h3>Newsletter</h3>
                <p>Inscrivez-vous pour recevoir nos actualités et offres exclusives</p>
                <!-- Formulaire d'inscription à la newsletter avec action vers le contrôleur approprié -->
                <form class="newsletter-form" action="?controller=newsletter&action=subscribe" method="POST">
                    <input type="email" name="email" placeholder="Votre email" required>
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        </div>
        
        <!-- <div class="payment-methods">
            <h3>Moyens de paiement</h3>
            <div class="payment-icons">
                <span class="payment-icon">💳</span>
                <span class="payment-icon">💳</span>
                <span class="payment-icon">💳</span>
                <span class="payment-icon">💳</span>
            </div>
        </div> -->
        
        <div class="copyright">
            <!-- Lien vers la page d'accueil sur le logo -->
            <a href="index.php">
                <img class="logo-image" src="./public/assets/image/logo-Cooldown.png" alt="Logo Cooldown Store">
            </a>
            <p>&copy; <?php echo date('Y'); ?> Cooldown Zone. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<!-- Ajout potentiel d'un modal de panier qui sera contrôlé par cart.js -->
<div id="cart-menu" class="cart-menu">
    <div class="cart-header">
        <span>Votre Panier</span>
        <button id="close-cart">&times;</button>
    </div>
    <div class="cart-content">
        <p>Votre panier est vide.</p>
    </div>
</div>

<!-- Overlay pour le panier et les menus mobiles -->
<div id="overlay" class="overlay"></div>

</body>
</html>