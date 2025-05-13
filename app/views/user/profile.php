<?php require_once 'app/views/layouts/header.php'; ?>

<main class="profile-page">
    <div class="container">
        <h1>Mon profil</h1>
        
        <div class="profile-container">
            <!-- Menu latéral du profil -->
            <div class="profile-sidebar">
                <div class="user-info">
                    <div class="user-avatar">
                        <img src="./public/assets/image/user-avatar.png" alt="Avatar">
                    </div>
                    <div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div>
                </div>
                
                <nav class="profile-nav">
                    <a href="?controller=user&action=profile" class="active">Informations personnelles</a>
                    <a href="?controller=user&action=orders">Mes commandes</a>
                    <a href="?controller=cart&action=view">Mon panier</a>
                    <a href="?controller=user&action=logout">Déconnexion</a>
                </nav>
            </div>
            
            <!-- Contenu principal du profil -->
            <div class="profile-content">
                <?php if (isset($_GET['success']) && $_GET['success'] === 'profile_updated'): ?>
                    <div class="alert alert-success">
                        Votre profil a été mis à jour avec succès.
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            $error = $_GET['error'];
                            if ($error === 'missing_fields') {
                                echo 'Veuillez remplir tous les champs obligatoires.';
                            } elseif ($error === 'email_exists') {
                                echo 'Cette adresse email est déjà utilisée.';
                            } elseif ($error === 'update_failed') {
                                echo 'La mise à jour a échoué. Veuillez réessayer.';
                            } else {
                                echo 'Une erreur est survenue. Veuillez réessayer.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="profile-section">
                    <h2>Informations personnelles</h2>
                    <form action="?controller=user&action=updateProfile" method="POST" id="profile-form">
                        <div class="form-group">
                            <label for="name">Nom complet</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Adresse email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
                
                <div class="profile-section">
                    <h2>Changer de mot de passe</h2>
                    <form action="?controller=user&action=updatePassword" method="POST" id="password-form">
                        <div class="form-group">
                            <label for="current_password">Mot de passe actuel</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">Nouveau mot de passe</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button-primary">Changer de mot de passe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation du formulaire de changement de mot de passe
    const passwordForm = document.getElementById('password-form');
    
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const currentPassword = document.getElementById('current_password').value;
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            // Vérifier que tous les champs sont remplis
            if (!currentPassword || !newPassword || !confirmPassword) {
                alert('Veuillez remplir tous les champs.');
                return;
            }
            
            // Vérifier que les mots de passe correspondent
            if (newPassword !== confirmPassword) {
                alert('Les nouveaux mots de passe ne correspondent pas.');
                return;
            }
            
            // Soumission du formulaire
            this.submit();
        });
    }
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>