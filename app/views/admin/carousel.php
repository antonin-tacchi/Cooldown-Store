<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Gestion du carrousel</h1>
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
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            $success = $_GET['success'];
                            if ($success === 'image_added') {
                                echo 'L\'image a été ajoutée avec succès.';
                            } elseif ($success === 'image_updated') {
                                echo 'L\'image a été mise à jour avec succès.';
                            } elseif ($success === 'image_deleted') {
                                echo 'L\'image a été supprimée avec succès.';
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
                                echo 'L\'ajout de l\'image a échoué. Veuillez réessayer.';
                            } elseif ($error === 'update_failed') {
                                echo 'La mise à jour de l\'image a échoué. Veuillez réessayer.';
                            } elseif ($error === 'delete_failed') {
                                echo 'La suppression de l\'image a échoué. Veuillez réessayer.';
                            } elseif ($error === 'image_required') {
                                echo 'Veuillez sélectionner une image.';
                            } elseif ($error === 'image_not_found') {
                                echo 'L\'image demandée n\'a pas été trouvée.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="admin-actions">
                    <a href="?controller=admin&action=addCarouselImage" class="button button-primary">Ajouter une image</a>
                </div>
                
                <div class="admin-section">
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Lien</th>
                                    <th>Position</th>
                                    <th>Actif</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($carouselImages) && !empty($carouselImages)): ?>
                                    <?php foreach ($carouselImages as $image): ?>
                                        <tr>
                                            <td>#<?php echo $image['id']; ?></td>
                                            <td>
                                                <div class="carousel-thumbnail">
                                                    <img src="./public/assets/image/products/<?php echo htmlspecialchars($image['image']); ?>" alt="<?php echo htmlspecialchars($image['title']); ?>">
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($image['title']); ?></td>
                                            <td>
                                                <?php if (!empty($image['link'])): ?>
                                                    <a href="<?php echo htmlspecialchars($image['link']); ?>" target="_blank">Voir</a>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $image['position']; ?></td>
                                            <td>
                                                <?php if ($image['active'] == 1): ?>
                                                    <span class="status active">Actif</span>
                                                <?php else: ?>
                                                    <span class="status inactive">Inactif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="actions">
                                                <a href="?controller=admin&action=editCarouselImage&id=<?php echo $image['id']; ?>" class="edit-btn" title="Modifier">✏️</a>
                                                <a href="?controller=admin&action=deleteCarouselImage&id=<?php echo $image['id']; ?>" class="delete-btn" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?');">🗑️</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Aucune image dans le carrousel.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Styles pour les miniatures de carrousel */
.carousel-thumbnail {
    width: 80px;
    height: 50px;
    border-radius: 4px;
    overflow: hidden;
}

.carousel-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.status {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
}

.status.active {
    background-color: #d4edda;
    color: #155724;
}

.status.inactive {
    background-color: #f8d7da;
    color: #721c24;
}
</style>

<?php require_once 'app/views/layouts/footer.php'; ?>