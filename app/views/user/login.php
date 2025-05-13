<?php require_once 'app/views/layouts/header.php'; ?>

<main class="auth-page">
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <h1>Connexion</h1>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            $error = $_GET['error'];
                            if ($error === 'missing_fields') {
                                echo 'Veuillez remplir tous les champs.';
                            } elseif ($error === 'invalid_credentials') {
                                echo 'Adresse email ou mot de passe incorrect.';
                            } else {
                                echo 'Une erreur est survenue. Veuillez réessayer.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <form action="?controller=user&action=doLogin" method="POST" id="login-form">
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <?php if (isset($_GET['redirect'])): ?>
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect']); ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <button type="submit" class="button button-primary">Se connecter</button>
                    </div>
                </form>
                
                <div class="auth-links">
                    <p>Vous n'avez pas de compte ? <a href="?controller=user&action=register">Créer un compte</a></p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        // Valider les données
        if (!email || !password) {
            alert('Veuillez remplir tous les champs.');
            return;
        }
        
        // Envoyer les données avec fetch
        const formData = new FormData(loginForm);
        
        fetch('?controller=user&action=doLogin', {
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
                // S'il y a une erreur, la page de connexion est rechargée
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

<style>
/* Styles pour les pages d'authentification */
.auth-page {
    padding: 40px 0;
}

.auth-container {
    max-width: 500px;
    margin: 0 auto;
}

.auth-box {
    background-color: #333;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.auth-box h1 {
    margin-bottom: 25px;
    text-align: center;
    color: white;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #ccc;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #444;
    background-color: #444;
    color: white;
    border-radius: 4px;
    transition: border-color 0.3s;
}

input:focus {
    outline: none;
    border-color: #6b9aff;
}

.button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button-primary {
    background-color: #6b9aff;
    color: white;
}

.button-primary:hover {
    background-color: #5a89ee;
}

.auth-links {
    margin-top: 20px;
    text-align: center;
    color: #ccc;
}

.auth-links a {
    color: #6b9aff;
    text-decoration: none;
}

.auth-links a:hover {
    text-decoration: underline;
}

.alert {
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-danger {
    background-color: rgba(244, 67, 54, 0.1);
    border: 1px solid rgba(244, 67, 54, 0.3);
    color: #F44336;
}
</style>

<?php require_once 'app/views/layouts/footer.php'; ?>