<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Gestion des utilisateurs</h1>
        </div>
        
        <div class="admin-container">
            <!-- Menu latéral admin -->
            <div class="admin-sidebar">
                <nav class="admin-nav">
                    <a href="?controller=admin&action=dashboard">Tableau de bord</a>
                    <a href="?controller=admin&action=products">Gestion des produits</a>
                    <a href="?controller=admin&action=categories">Gestion des catégories</a>
                    <a href="?controller=admin&action=orders">Gestion des commandes</a>
                    <a href="?controller=admin&action=users" class="active">Gestion des utilisateurs</a>
                    <a href="index.php">Retour au site</a>
                </nav>
            </div>
            
            <!-- Contenu principal -->
            <div class="admin-content">
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            $success = $_GET['success'];
                            if ($success === 'user_updated') {
                                echo 'L\'utilisateur a été mis à jour avec succès.';
                            } elseif ($success === 'user_deleted') {
                                echo 'L\'utilisateur a été supprimé avec succès.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            $error = $_GET['error'];
                            if ($error === 'update_failed') {
                                echo 'La mise à jour de l\'utilisateur a échoué. Veuillez réessayer.';
                            } elseif ($error === 'delete_failed') {
                                echo 'La suppression de l\'utilisateur a échoué. Veuillez réessayer.';
                            } elseif ($error === 'cannot_delete_self') {
                                echo 'Vous ne pouvez pas supprimer votre propre compte.';
                            } elseif ($error === 'cannot_delete_admin') {
                                echo 'Vous ne pouvez pas supprimer le compte administrateur principal.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="admin-section">
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Date d'inscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>#<?php echo $user['id']; ?></td>
                                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td>
                                            <span class="role-badge <?php echo $user['role']; ?>">
                                                <?php echo $user['role'] === 'admin' ? 'Administrateur' : 'Utilisateur'; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                        <td class="actions">
                                            <form class="role-form" action="?controller=admin&action=updateUserRole" method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <select name="role" class="role-select" onchange="this.form.submit()">
                                                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                                                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                                                </select>
                                            </form>
                                            
                                            <a href="?controller=admin&action=deleteUser&id=<?php echo $user['id']; ?>" class="delete-btn" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">🗑️</a>
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