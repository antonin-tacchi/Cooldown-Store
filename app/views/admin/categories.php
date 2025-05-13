<?php
require_once 'app/views/layouts/header.php';
// Déterminer l'action actuelle
$currentAction = isset($_GET['action']) ? $_GET['action'] : 'dashboard';
 ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Gestion des catégories</h1>
        </div>
        
        <div class="admin-container">
            <!-- Menu latéral admin -->
            <div class="admin-sidebar">
                <nav class="admin-nav">
                    <a href="?controller=admin&action=dashboard" <?php echo ($currentAction === 'dashboard') ? 'class="active"' : ''; ?>>Tableau de bord</a>
                    <a href="?controller=admin&action=products" <?php echo ($currentAction === 'products') ? 'class="active"' : ''; ?>>Gestion des produits</a>
                    <a href="?controller=admin&action=categories" <?php echo ($currentAction === 'categories') ? 'class="active"' : ''; ?>>Gestion des catégories</a>
                    <a href="?controller=admin&action=orders" <?php echo ($currentAction === 'orders') ? 'class="active"' : ''; ?>>Gestion des commandes</a>
                    <a href="?controller=admin&action=users" <?php echo ($currentAction === 'users') ? 'class="active"' : ''; ?>>Gestion des utilisateurs</a>
                    <a href="?controller=admin&action=carousel" <?php echo ($currentAction === 'carousel') ? 'class="active"' : ''; ?>>Carrousel</a>
                    <a href="index.php">Retour au site</a>
                </nav>
            </div>
            
            <!-- Contenu principal -->
            <div class="admin-content">
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            $success = $_GET['success'];
                            if ($success === 'category_added') {
                                echo 'La catégorie a été ajoutée avec succès.';
                            } elseif ($success === 'category_updated') {
                                echo 'La catégorie a été mise à jour avec succès.';
                            } elseif ($success === 'category_deleted') {
                                echo 'La catégorie a été supprimée avec succès.';
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
                                echo 'L\'ajout de la catégorie a échoué. Veuillez réessayer.';
                            } elseif ($error === 'update_failed') {
                                echo 'La mise à jour de la catégorie a échoué. Veuillez réessayer.';
                            } elseif ($error === 'delete_failed') {
                                echo 'La suppression de la catégorie a échoué. Veuillez réessayer.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="admin-actions">
                    <a href="?controller=admin&action=addCategory" class="button button-primary">Ajouter une catégorie</a>
                </div>
                
                <div class="admin-section">
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td>#<?php echo $category['id']; ?></td>
                                        <td>
                                            <div class="category-thumbnail">
                                                <img src="./public/assets/image/categories/<?php echo htmlspecialchars($category['image']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                                        <td class="actions">
                                            <a href="?controller=admin&action=editCategory&id=<?php echo $category['id']; ?>" class="edit-btn" title="Modifier">✏️</a>
                                            <a href="?controller=admin&action=deleteCategory&id=<?php echo $category['id']; ?>" class="delete-btn" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Tous les produits associés seront également supprimés.');">🗑️</a>
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

<style>
/* Styles pour les miniatures de catégories */
.category-thumbnail {
    width: 50px;
    height: 50px;
    border-radius: 4px;
    overflow: hidden;
}

.category-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>

<?php require_once 'app/views/layouts/footer.php'; ?>