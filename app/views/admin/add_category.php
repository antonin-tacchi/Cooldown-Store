<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Ajouter une catégorie</h1>
        </div>
        
        <div class="admin-container">
            <!-- Menu latéral admin -->
            <div class="admin-sidebar">
                <nav class="admin-nav">
                    <a href="?controller=admin&action=dashboard">Tableau de bord</a>
                    <a href="?controller=admin&action=products">Gestion des produits</a>
                    <a href="?controller=admin&action=categories" class="active">Gestion des catégories</a>
                    <a href="?controller=admin&action=orders">Gestion des commandes</a>
                    <a href="?controller=admin&action=users">Gestion des utilisateurs</a>
                    <a href="index.php">Retour au site</a>
                </nav>
            </div>
            
            <!-- Contenu principal -->
            <div class="admin-content">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            $error = $_GET['error'];
                            if ($error === 'missing_fields') {
                                echo 'Veuillez remplir tous les champs obligatoires.';
                            } elseif ($error === 'add_failed') {
                                echo 'L\'ajout de la catégorie a échoué. Veuillez réessayer.';
                            } else {
                                echo 'Une erreur est survenue. Veuillez réessayer.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="admin-section">
                    <form action="?controller=admin&action=doAddCategory" method="POST" enctype="multipart/form-data" class="admin-form">
                        <div class="form-group">
                            <label for="name">Nom de la catégorie *</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Image de la catégorie *</label>
                            <input type="file" id="image" name="image" class="form-control" required>
                            <small class="form-text">Formats acceptés : JPG, JPEG, PNG, GIF. Taille max : 2 Mo. Dimensions recommandées : 800x600px.</small>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button-primary">Ajouter la catégorie</button>
                            <a href="?controller=admin&action=categories" class="button button-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'app/views/layouts/footer.php'; ?>