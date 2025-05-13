<?php require_once 'app/views/layouts/header.php'; ?>

<main class="auth-page">
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <h1>Créer un compte</h1>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            $error = $_GET['error'];
                            if ($error === 'missing_fields') {
                                echo 'Veuillez remplir tous les champs.';
                            } elseif ($error === 'password_mismatch') {
                                echo 'Les mots de passe ne correspondent pas.';
                            } elseif ($error === 'email_exists') {
                                echo 'Cette adresse email est déjà utilisée.';
                            } elseif ($error === 'registration_failed') {
                                echo 'L\'inscription a échoué. Veuillez réessayer.';
                            } else {
                                echo 'Une erreur est survenue. Veuillez réessayer.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <form action="?controller=user&action=doRegister" method="POST" id="register-form">
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirm">Confirmer le mot de passe</label>
                        <input type="password" id="password_confirm" name="password_confirm" required>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="button button-primary">Créer un compte</button>
                    </div>
                </form>
                
                <div class="auth-links">
                    <p>Vous avez déjà un compte ? <a href="?controller=user&action=login">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('register-form');
    
    registerForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirm').value;
        
        // Valider les données
        if (!name || !email || !password || !passwordConfirm) {
            alert('Veuillez remplir tous les champs.');
            return;
        }
        
        // Vérifier que les mots de passe correspondent
        if (password !== passwordConfirm) {
            alert('Les mots de passe ne correspondent pas.');
            return;
        }
        
        // Envoyer les données avec fetch
        const formData = new FormData(registerForm);
        
        fetch('?controller=user&action=doRegister', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                return response.text();
            }
        })
        .then(html => {
            if (html) {
                // S'il y a une erreur, la page d'inscription est rechargée
                // Extraire le message d'erreur
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const errorAlert = doc.querySelector('.alert-danger');
                
                if (errorAlert) {
                    alert(errorAlert.textContent.trim());
                } else {
                    alert('Une erreur est survenue. Veuillez réessayer.');
                }
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
    });
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>