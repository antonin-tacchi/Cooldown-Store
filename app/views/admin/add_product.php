<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Ajouter un produit</h1>
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
                            } elseif ($error === 'add_failed') {
                                echo 'L\'ajout du produit a échoué. Veuillez réessayer.';
                            } else {
                                echo 'Une erreur est survenue. Veuillez réessayer.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="admin-section">
                    <form action="?controller=admin&action=doAddProduct" method="POST" class="admin-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Nom du produit *</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="price">Prix (€) *</label>
                                <input type="number" id="price" name="price" step="0.01" min="0" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="category_id">Catégorie *</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <option value="">Sélectionner une catégorie</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="stock">Stock *</label>
                                <input type="number" id="stock" name="stock" min="0" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea id="description" name="description" class="form-control" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="image">URL de l'image du produit</label>
                            <input type="text" id="image" name="image" class="form-control" placeholder="https://exemple.com/image.jpg">
                            <small class="form-text">Entrez l'URL complète de l'image</small>
                        </div>
                        
                        <div class="form-check">
                            <input type="checkbox" id="featured" name="featured" value="1">
                            <label for="featured">Mettre en vedette sur la page d'accueil</label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="button button-primary">Ajouter le produit</button>
                            <a href="?controller=admin&action=products" class="button button-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'app/views/layouts/footer.php'; ?>