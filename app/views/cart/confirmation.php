<?php require_once 'app/views/layouts/header.php'; ?>

<main class="confirmation-page">
    <div class="container">
        <div class="confirmation-box">
            <div class="confirmation-icon">✓</div>
            <h1>Merci pour votre commande !</h1>
            <p>Votre commande a été traitée avec succès.</p>
            
            <div class="confirmation-details">
                <p>Un e-mail de confirmation vient de vous être envoyé avec tous les détails de votre commande.</p>
                <p>Numéro de commande: <strong>#<?php echo rand(10000, 99999); ?></strong></p>
                <p>Vous pouvez suivre l'état de votre commande dans votre espace compte.</p>
            </div>
            
            <div class="confirmation-actions">
                <a href="index.php" class="button button-primary">Retour à l'accueil</a>
                <a href="?controller=user&action=orders" class="button button-secondary">Voir mes commandes</a>
            </div>
        </div>
    </div>
</main>

<?php require_once 'app/views/layouts/footer.php'; ?>