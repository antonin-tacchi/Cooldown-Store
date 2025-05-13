<?php require_once 'app/views/layouts/header.php'; ?>

<main class="cart-page">
    <div class="container">
        <h1>Votre panier</h1>
        
        <?php if (empty($cart)): ?>
            <div class="empty-cart">
                <p>Votre panier est vide.</p>
                <a href="?controller=product&action=list" class="button button-primary">Continuer mes achats</a>
            </div>
        <?php else: ?>
            <div class="cart-container">
                <div class="cart-items">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th class="product-col">Produit</th>
                                <th class="price-col">Prix</th>
                                <th class="quantity-col">Quantité</th>
                                <th class="subtotal-col">Sous-total</th>
                                <th class="remove-col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $item): ?>
                                <tr class="cart-item" data-id="<?php echo $item['id']; ?>">
                                    <td class="product-col">
                                        <div class="product-info">
                                            <img src="./public/assets/image/products/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                            <div class="product-details">
                                                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price-col"><?php echo number_format($item['price'], 2); ?> €</td>
                                    <td class="quantity-col">
                                        <div class="quantity-selector">
                                            <button class="quantity-btn minus" data-id="<?php echo $item['id']; ?>">-</button>
                                            <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1" data-id="<?php echo $item['id']; ?>">
                                            <button class="quantity-btn plus" data-id="<?php echo $item['id']; ?>">+</button>
                                        </div>
                                    </td>
                                    <td class="subtotal-col"><?php echo number_format($item['subtotal'], 2); ?> €</td>
                                    <td class="remove-col">
                                        <button class="remove-item" data-id="<?php echo $item['id']; ?>">&times;</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="cart-summary">
                    <h2>Récapitulatif</h2>
                    
                    <div class="cart-totals">
                        <div class="cart-total-row">
                            <span>Sous-total</span>
                            <span id="cart-subtotal"><?php echo number_format($total, 2); ?> €</span>
                        </div>
                        <div class="cart-total-row">
                            <span>Livraison</span>
                            <span>Gratuit</span>
                        </div>
                        <div class="cart-total-row total">
                            <span>Total</span>
                            <span id="cart-total"><?php echo number_format($total, 2); ?> €</span>
                        </div>
                    </div>
                    
                    <div class="cart-actions">
                        <a href="?controller=product&action=list" class="button button-secondary">Continuer mes achats</a>
                        <a href="?controller=cart&action=checkout" class="button button-primary">Valider ma commande</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire pour les boutons de quantité
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            let quantity = parseInt(input.value);
            
            if (this.classList.contains('minus') && quantity > 1) {
                quantity--;
            } else if (this.classList.contains('plus')) {
                quantity++;
            }
            
            input.value = quantity;
            updateCartItem(productId, quantity);
        });
    });
    
    // Gestionnaire pour les inputs de quantité
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.dataset.id;
            let quantity = parseInt(this.value);
            
            if (quantity < 1) {
                quantity = 1;
                this.value = 1;
            }
            
            updateCartItem(productId, quantity);
        });
    });
    
    // Gestionnaire pour les boutons de suppression
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            removeCartItem(productId);
        });
    });
    
    // Fonction pour mettre à jour un article dans le panier
    function updateCartItem(productId, quantity) {
        fetch('?controller=cart&action=update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recharger la page pour actualiser les totaux
                location.reload();
            } else {
                alert('Erreur : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }
    
    // Fonction pour supprimer un article du panier
    function removeCartItem(productId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet article de votre panier ?')) {
            fetch('?controller=cart&action=remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Recharger la page pour actualiser le panier
                    location.reload();
                } else {
                    alert('Erreur : ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        }
    }
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>