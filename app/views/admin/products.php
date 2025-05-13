<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Gestion des produits</h1>
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
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            $success = $_GET['success'];
                            if ($success === 'product_added') {
                                echo 'Le produit a été ajouté avec succès.';
                            } elseif ($success === 'product_updated') {
                                echo 'Le produit a été mis à jour avec succès.';
                            } elseif ($success === 'product_deleted') {
                                echo 'Le produit a été supprimé avec succès.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            $error = $_GET['error'];
                            if ($error === 'missing_fields') {
                                echo 'Veuillez remplir tous les champs obligatoires.';
                            } elseif ($error === 'add_failed') {
                                echo 'L\'ajout du produit a échoué. Veuillez réessayer.';
                            } elseif ($error === 'update_failed') {
                                echo 'La mise à jour du produit a échoué. Veuillez réessayer.';
                            } elseif ($error === 'delete_failed') {
                                echo 'La suppression du produit a échoué. Veuillez réessayer.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="admin-actions">
                    <a href="?controller=admin&action=addProduct" class="button button-primary">Ajouter un produit</a>
                </div>
                
                <div class="admin-section">
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Stock</th>
                                    <th>Catégorie</th>
                                    <th>En vedette</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>#<?php echo $product['id']; ?></td>
                                        <td>
                                            <div class="product-thumbnail">
                                                <img src="./public/assets/image/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td><?php echo number_format($product['price'], 2); ?> €</td>
                                        <td><?php echo $product['stock']; ?></td>
                                        <td>
                                            <?php 
                                                // Dans un projet réel, il faudrait récupérer le nom de la catégorie
                                                echo 'Catégorie ' . $product['category_id'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $product['featured'] ? 'Oui' : 'Non'; ?>
                                        </td>
                                        <td class="actions">
                                            <a href="?controller=admin&action=editProduct&id=<?php echo $product['id']; ?>" class="edit-btn" title="Modifier">✏️</a>
                                            <a href="?controller=admin&action=deleteProduct&id=<?php echo $product['id']; ?>" class="delete-btn" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">🗑️</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'app/views/layouts/footer.php'; ?>