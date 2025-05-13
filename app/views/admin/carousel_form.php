<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1><?php echo isset($image) ? 'Modifier l\'image du carrousel' : 'Ajouter une image au carrousel'; ?></h1>
        </div>
        
        <div class="admin-container">
            <!-- Menu latéral admin -->
            <div class="admin-sidebar">
                <nav class="admin-nav">
                    <a href="?controller=admin&action=dashboard">Tableau de bord</a>
                    <a href="?controller=admin&action=products">Gestion des produits</a>
                    <a href="?controller=admin&action=categories">Gestion des catégories</a>
                    <a href="?controller=admin&action=orders">Gestion des commandes</a>
                    <a href="?controller=admin&action=users">Gestion des utilisateurs</a>
                    <a href="?controller=admin&action=carousel" class="active">Carrousel</a>
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
                                echo 'L\'ajout de l\'image a échoué. Veuillez réessayer.';
                            } elseif ($error === 'update_failed') {
                                echo 'La mise à jour de l\'image a échoué. Veuillez réessayer.';
                            } elseif ($error === 'image_required') {
                                echo 'Veuillez sélectionner une image.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="admin-form-container">
                    <form action="?controller=admin&action=<?php echo isset($image) ? 'doEditCarouselImage' : 'doAddCarouselImage'; ?>" method="post" enctype="multipart/form-data" class="admin-form">
                        <?php if (isset($image)): ?>
                            <input type="hidden" name="id" value="<?php echo $image['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="title">Titre de l'image</label>
                            <input type="text" id="title" name="title" value="<?php echo isset($image) ? htmlspecialchars($image['title']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Image</label>
                            <?php if (isset($image) && !empty($image['image'])): ?>
                                <div class="current-image">
                                    <img src="./public/assets/image/products/<?php echo htmlspecialchars($image['image']); ?>" alt="<?php echo htmlspecialchars($image['title']); ?>">
                                    <p>Image actuelle</p>
                                </div>
                            <?php endif; ?>
                            <input type="file" id="image" name="image" <?php echo isset($image) ? '' : 'required'; ?>>
                            <small>Format recommandé: 1920 x 500 pixels.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="link">Lien (optionnel)</label>
                            <input type="text" id="link" name="link" value="<?php echo isset($image) ? htmlspecialchars($image['link']) : ''; ?>">
                            <small>Exemple: ?controller=product&action=detail&id=1</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="number" id="position" name="position" value="<?php echo isset($image) ? $image['position'] : '0'; ?>" min="0">
                            <small>Plus le chiffre est petit, plus l'image apparaîtra en premier.</small>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label>
                                <input type="checkbox" name="active" value="1" <?php echo (isset($image) && $image['active'] == 1) ? 'checked' : ''; ?>>
                                Activer l'image
                            </label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button-primary"><?php echo isset($image) ? 'Mettre à jour' : 'Ajouter'; ?></button>
                            <a href="?controller=admin&action=carousel" class="button button-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Styles pour le formulaire */
.current-image {
    margin-bottom: 10px;
}

.current-image img {
    max-width: 300px;
    max-height: 100px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 5px;
}

.current-image p {
    font-size: 0.9em;
    color: #666;
}
</style>

<?php require_once 'app/views/layouts/footer.php'; ?>