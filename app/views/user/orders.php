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
                            $success = $_GET['success'];
                            if ($success === 'status_updated') {
                                echo 'Le statut de la commande a été mis à jour avec succès.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            $error = $_GET['error'];
                            if ($error === 'update_failed') {
                                echo 'La mise à jour du statut de la commande a échoué. Veuillez réessayer.';
                            } elseif ($error === 'missing_fields') {
                                echo 'Veuillez remplir tous les champs obligatoires.';
                            }
                        ?>
                    </div>
                <?php endif; ?>
                
                <div class="orders-filter">
                    <form action="?controller=admin&action=orders" method="GET" class="filter-form">
                        <input type="hidden" name="controller" value="admin">
                        <input type="hidden" name="action" value="orders">
                        
                        <div class="form-group">
                            <label for="status">Filtrer par statut :</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Tous les statuts</option>
                                <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'selected' : ''; ?>>En attente</option>
                                <option value="processing" <?php echo (isset($_GET['status']) && $_GET['status'] === 'processing') ? 'selected' : ''; ?>>En traitement</option>
                                <option value="shipped" <?php echo (isset($_GET['status']) && $_GET['status'] === 'shipped') ? 'selected' : ''; ?>>Expédiée</option>
                                <option value="delivered" <?php echo (isset($_GET['status']) && $_GET['status'] === 'delivered') ? 'selected' : ''; ?>>Livrée</option>
                                <option value="cancelled" <?php echo (isset($_GET['status']) && $_GET['status'] === 'cancelled') ? 'selected' : ''; ?>>Annulée</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="button button-primary">Filtrer</button>
                    </form>
                </div>
                
                <div class="admin-section">
                    <div class="admin-table-container">
                        <table class="admin-table">
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
                                        <td colspan="6" class="text-center">Aucune commande trouvée.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>#<?php echo $order['id']; ?></td>
                                            <td>
                                                <?php echo htmlspecialchars($order['user_name']); ?><br>
                                                <small><?php echo htmlspecialchars($order['user_email']); ?></small>
                                            </td>
                                            <td><?php echo number_format($order['total_amount'], 2); ?> €</td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                            <td>
                                                <span class="status-badge <?php echo $order['status']; ?>">
                                                    <?php 
                                                        $status = $order['status'];
                                                        if ($status === 'pending') echo 'En attente';
                                                        elseif ($status === 'processing') echo 'En traitement';
                                                        elseif ($status === 'shipped') echo 'Expédiée';
                                                        elseif ($status === 'delivered') echo 'Livrée';
                                                        elseif ($status === 'cancelled') echo 'Annulée';
                                                        else echo $status;
                                                    ?>
                                                </span>
                                            </td>
                                            <td class="actions">
                                                <button class="view-order-btn" title="Voir les détails" data-id="<?php echo $order['id']; ?>">👁️</button>
                                                
                                                <form class="status-form" action="?controller=admin&action=updateOrderStatus" method="POST" style="display: inline;">
                                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                                        <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>En attente</option>
                                                        <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>En traitement</option>
                                                        <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Expédiée</option>
                                                        <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Livrée</option>
                                                        <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Annulée</option>
                                                    </select>
                                                </form>
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
    
    <!-- Modal pour les détails de commande -->
    <div id="order-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Détails de la commande #<span id="order-id"></span></h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="order-details">
                    <div class="order-info">
                        <h3>Informations générales</h3>
                        <p><strong>Client:</strong> <span id="order-client"></span></p>
                        <p><strong>Email:</strong> <span id="order-email"></span></p>
                        <p><strong>Date:</strong> <span id="order-date"></span></p>
                        <p><strong>Statut:</strong> <span id="order-status"></span></p>
                        <p><strong>Total:</strong> <span id="order-total"></span></p>
                    </div>
                    
                    <div class="order-address">
                        <h3>Adresse de livraison</h3>
                        <p id="order-address"></p>
                    </div>
                </div>
                
                <div class="order-items">
                    <h3>Produits commandés</h3>
                    <table class="order-items-table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                            </tr>
                        </thead>
                        <tbody id="order-items-list">
                            <!-- Les éléments seront ajoutés dynamiquement -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire pour ouvrir le modal
    const viewButtons = document.querySelectorAll('.view-order-btn');
    const modal = document.getElementById('order-modal');
    const closeModal = document.querySelector('.close-modal');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.id;
            
            // Récupérer les détails de la commande via une requête AJAX
            fetch(`?controller=admin&action=getOrderDetails&id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour les informations dans le modal
                        document.getElementById('order-id').textContent = data.order.id;
                        document.getElementById('order-client').textContent = data.order.user_name;
                        document.getElementById('order-email').textContent = data.order.user_email;
                        document.getElementById('order-date').textContent = data.order.created_at;
                        
                        // Mettre à jour le statut
                        let statusText = '';
                        const status = data.order.status;
                        
                        if (status === 'pending') statusText = 'En attente';
                        else if (status === 'processing') statusText = 'En traitement';
                        else if (status === 'shipped') statusText = 'Expédiée';
                        else if (status === 'delivered') statusText = 'Livrée';
                        else if (status === 'cancelled') statusText = 'Annulée';
                        else statusText = status;
                        
                        document.getElementById('order-status').innerHTML = `<span class="status-badge ${status}">${statusText}</span>`;
                        
                        document.getElementById('order-total').textContent = `${parseFloat(data.order.total_amount).toFixed(2)} €`;
                        
                        // Mettre à jour l'adresse
                        document.getElementById('order-address').innerHTML = `
                            ${data.order.shipping_address}<br>
                            ${data.order.shipping_zip} ${data.order.shipping_city}<br>
                            ${data.order.shipping_country}
                        `;
                        
                        // Mettre à jour les produits
                        const itemsList = document.getElementById('order-items-list');
                        itemsList.innerHTML = '';
                        
                        data.order.items.forEach(item => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${item.name}</td>
                                <td>${parseFloat(item.price).toFixed(2)} €</td>
                                <td>${item.quantity}</td>
                                <td>${(parseFloat(item.price) * parseInt(item.quantity)).toFixed(2)} €</td>
                            `;
                            itemsList.appendChild(row);
                        });
                        
                        // Afficher le modal
                        modal.style.display = 'block';
                    } else {
                        alert('Erreur : ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue. Veuillez réessayer.');
                });
        });
    });
    
    // Fermer le modal
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Fermer le modal en cliquant en dehors
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>