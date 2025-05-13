<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Gestion des commandes</h1>
        </div>
        
        <div class="admin-container">
            <!-- Menu latéral admin -->
            <div class="admin-sidebar">
                <nav class="admin-nav">
                    <a href="?controller=admin&action=dashboard">Tableau de bord</a>
                    <a href="?controller=admin&action=products">Gestion des produits</a>
                    <a href="?controller=admin&action=categories">Gestion des catégories</a>
                    <a href="?controller=admin&action=orders" class="active">Gestion des commandes</a>
                    <a href="?controller=admin&action=users">Gestion des utilisateurs</a>
                    <a href="index.php">Retour au site</a>
                </nav>
            </div>
            
            <!-- Contenu principal -->
            <div class="admin-content">
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            $message = '';
                            switch ($_GET['success']) {
                                case 'status_updated':
                                    $message = 'Le statut de la commande a été mis à jour avec succès.';
                                    break;
                                default:
                                    $message = 'Opération réussie.';
                            }
                            echo $message;
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            $message = '';
                            switch ($_GET['error']) {
                                case 'missing_fields':
                                    $message = 'Tous les champs requis doivent être remplis.';
                                    break;
                                case 'update_failed':
                                    $message = 'La mise à jour du statut a échoué.';
                                    break;
                                default:
                                    $message = 'Une erreur s\'est produite.';
                            }
                            echo $message;
                        ?>
                    </div>
                <?php endif; ?>

                <div class="dashboard-section">
                    <h2>Toutes les commandes</h2>
                    <div class="dashboard-table-container">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($orders)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Aucune commande trouvée</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>#<?= htmlspecialchars($order['id']) ?></td>
                                            <td><?= htmlspecialchars($order['user_email'] ?? 'Client invité') ?></td>
                                            <td><?= number_format($order['total_amount'], 2, ',', ' ') ?> €</td>
                                            <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                                            <td>
                                                <span class="status-badge <?= $order['status'] ?>">
                                                    <?= getStatusLabel($order['status']) ?>
                                                </span>
                                            </td>
                                            <td class="actions">
                                                <button type="button" class="button button-small" 
                                                        onclick="openOrderDetails(<?= $order['id'] ?>)">
                                                    Détails
                                                </button>
                                                <button type="button" class="button button-small button-secondary" 
                                                        onclick="openStatusModal(<?= $order['id'] ?>)">
                                                    Statut
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modals pour les détails et le changement de statut -->
<?php if (!empty($orders)): ?>
    <?php foreach ($orders as $order): ?>
        <!-- Modal Détails -->
        <div id="orderDetailsModal<?= $order['id'] ?>" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Détails de la commande #<?= $order['id'] ?></h2>
                    <span class="close" onclick="closeOrderDetails(<?= $order['id'] ?>)">&times;</span>
                </div>
                <div class="modal-body">
                    <!-- Informations de la commande -->
                    <div class="order-info">
                        <div class="order-info-section">
                            <h3>Informations client</h3>
                            <p><strong>Email:</strong> <?= htmlspecialchars($order['user_email'] ?? 'Client invité') ?></p>
                            <p><strong>Date de commande:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                        <div class="order-info-section">
                            <h3>Informations de livraison</h3>
                            <p><strong>Adresse:</strong> <?= htmlspecialchars($order['shipping_address'] ?? 'Non renseignée') ?></p>
                            <p><strong>Méthode de paiement:</strong> <?= htmlspecialchars($order['payment_method'] ?? 'Non renseignée') ?></p>
                        </div>
                    </div>
                    
                    <!-- Produits de la commande -->
                    <h3>Produits commandés</h3>
                    <?php 
                    // Nous devons récupérer les détails de la commande
                    $orderDetails = $orderModel->getOrderDetails($order['id']);
                    if (empty($orderDetails)): 
                    ?>
                        <p>Aucun produit trouvé pour cette commande.</p>
                    <?php else: ?>
                        <div class="order-items">
                            <table class="dashboard-table">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderDetails as $item): ?>
                                        <tr>
                                            <td class="product-cell">
                                                <?php if (!empty($item['product_image'])): ?>
                                                    <img src="public/assets/image/products/<?= $item['product_image'] ?>" 
                                                         alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                                         class="product-thumbnail">
                                                <?php endif; ?>
                                                <span><?= htmlspecialchars($item['product_name']) ?></span>
                                            </td>
                                            <td><?= number_format($item['price'], 2, ',', ' ') ?> €</td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td><?= number_format($item['price'] * $item['quantity'], 2, ',', ' ') ?> €</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                        <td><strong><?= number_format($order['total_amount'], 2, ',', ' ') ?> €</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button class="button button-secondary" onclick="closeOrderDetails(<?= $order['id'] ?>)">Fermer</button>
                </div>
            </div>
        </div>
        
        <!-- Modal Statut -->
        <div id="statusModal<?= $order['id'] ?>" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Modifier le statut de la commande #<?= $order['id'] ?></h2>
                    <span class="close" onclick="closeStatusModal(<?= $order['id'] ?>)">&times;</span>
                </div>
                <form action="?controller=admin&action=updateOrderStatus" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <div class="form-group">
                            <label for="status<?= $order['id'] ?>">Statut</label>
                            <select class="form-control" id="status<?= $order['id'] ?>" name="status" required>
                                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>
                                    En attente
                                </option>
                                <option value="processing" <?= $order['status'] == 'processing' ? 'selected' : '' ?>>
                                    En traitement
                                </option>
                                <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>
                                    Expédiée
                                </option>
                                <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>
                                    Livrée
                                </option>
                                <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>
                                    Annulée
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button" onclick="closeStatusModal(<?= $order['id'] ?>)">Annuler</button>
                        <button type="submit" class="button button-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- JavaScript pour les modals -->
<script>
    // Functions to handle the order details modal
    function openOrderDetails(orderId) {
        document.getElementById('orderDetailsModal' + orderId).style.display = 'block';
    }
    
    function closeOrderDetails(orderId) {
        document.getElementById('orderDetailsModal' + orderId).style.display = 'none';
    }
    
    // Functions to handle the status modal
    function openStatusModal(orderId) {
        document.getElementById('statusModal' + orderId).style.display = 'block';
    }
    
    function closeStatusModal(orderId) {
        document.getElementById('statusModal' + orderId).style.display = 'none';
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>

<?php
// Fonction pour obtenir le libellé en français du statut
function getStatusLabel($status) {
    switch ($status) {
        case 'pending':
            return 'En attente';
        case 'processing':
            return 'En traitement';
        case 'shipped':
            return 'Expédiée';
        case 'delivered':
            return 'Livrée';
        case 'cancelled':
            return 'Annulée';
        default:
            return ucfirst($status);
    }
}
?>

<?php require_once 'app/views/layouts/footer.php'; ?>