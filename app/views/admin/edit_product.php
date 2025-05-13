<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Modifier un produit</h1>
        </div>
        
        <div class="admin-container">
            <!-- Menu latéral admin -->
            <div class="admin-sidebar">
                <nav class="admin-nav">
                    <a href="?controller=admin&action=dashboard">Tableau de bord</a>
                    <a href="?controller=admin&action=products" class="active">Gestion des produits</a>
                    <a href="?controller=admin&action=categories">Gestion des catégories</a>
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
                                echo 'La mise à jour du produit a échoué. Veuillez réessayer.';
                            } else {
                                echo 'Une erreur est survenue. Veuillez réessayer.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="admin-section">
                    <form action="?controller=admin&action=doEditProduct" method="POST" enctype="multipart/form-data" class="admin-form">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Nom du produit *</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="price">Prix (€) *</label>
                                <input type="number" id="price" name="price" step="0.01" min="0" class="form-control" value="<?php echo $product['price']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="category_id">Catégorie *</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="stock">Stock *</label>
                                <input type="number" id="stock" name="stock" min="0" class="form-control" value="<?php echo $product['stock']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Image actuelle</label>
                            <div class="current-image">
                                <img src="./public/assets/image/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Nouvelle image</label>
                            <input type="file" id="image" name="image" class="form-control">
                            <small class="form-text">Laissez vide pour conserver l'image actuelle. Formats acceptés : JPG, JPEG, PNG, GIF. Taille max : 2 Mo.</small>
                        </div>
                        
                        <div class="form-check">
                            <input type="checkbox" id="featured" name="featured" value="1" <?php echo ($product['featured']) ? 'checked' : ''; ?>>
                            <label for="featured">Mettre en vedette sur la page d'accueil</label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button-primary">Enregistrer les modifications</button>
                            <a href="?controller=admin&action=products" class="button button-secondary">Annuler</a>
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
    height: 150px;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 15px;
}

.current-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Texte d'aide du formulaire */
.form-text {
    display: block;
    margin-top: 5px;
    font-size: 0.85rem;
    color: #aaa;
}
</style>

<?php require_once 'app/views/layouts/footer.php'; ?>