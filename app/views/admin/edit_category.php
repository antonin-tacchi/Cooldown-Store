<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Modifier une catégorie</h1>
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
                            } elseif ($error === 'update_failed') {
                                echo 'La mise à jour de la catégorie a échoué. Veuillez réessayer.';
                            } else {
                                echo 'Une erreur est survenue. Veuillez réessayer.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="admin-section">
                    <form action="?controller=admin&action=doEditCategory" method="POST" enctype="multipart/form-data" class="admin-form">
                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                        
                        <div class="form-group">
                            <label for="name">Nom de la catégorie *</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Image actuelle</label>
                            <div class="current-image">
                                <img src="./public/assets/image/categories/<?php echo htmlspecialchars($category['image']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Nouvelle image</label>
                            <input type="file" id="image" name="image" class="form-control">
                            <small class="form-text">Laissez vide pour conserver l'image actuelle. Formats acceptés : JPG, JPEG, PNG, GIF. Taille max : 2 Mo. Dimensions recommandées : 800x600px.</small>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button-primary">Enregistrer les modifications</button>
                            <a href="?controller=admin&action=categories" class="button button-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Style pour l'image actuelle */
.current-image {
    width: 150px;
    height: 100px;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 15px;
}

.current-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>

<?php require_once 'app/views/layouts/footer.php'; ?>