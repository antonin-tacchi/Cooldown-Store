<?php require_once 'app/views/layouts/header.php'; ?>

<main class="checkout-page">
    <div class="container">
        <h1>Finaliser votre commande</h1>
        
        <form action="?controller=cart&action=processOrder" method="POST" id="checkout-form">
            <div class="checkout-container">
                <div class="checkout-info">
                    <section class="checkout-section">
                        <h2>Adresse de livraison</h2>
                        <div class="form-group">
                            <label for="shipping_address">Adresse</label>
                            <input type="text" id="shipping_address" name="shipping_address" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="shipping_zip">Code postal</label>
                                <input type="text" id="shipping_zip" name="shipping_zip" required>
                            </div>
                            <div class="form-group">
                                <label for="shipping_city">Ville</label>
                                <input type="text" id="shipping_city" name="shipping_city" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shipping_country">Pays</label>
                            <select id="shipping_country" name="shipping_country" required>
                                <option value="">Sélectionnez un pays</option>
                                <option value="FR">France</option>
                                <option value="BE">Belgique</option>
                                <option value="CH">Suisse</option>
                                <option value="LU">Luxembourg</option>
                                <option value="CA">Canada</option>
                            </select>
                        </div>
                    </section>
                    
                    <section class="checkout-section">
                        <h2>Mode de paiement</h2>
                        <div class="payment-methods">
                            <div class="payment-method">
                                <input type="radio" id="payment_cc" name="payment_method" value="credit_card" required>
                                <label for="payment_cc">
                                    <span class="payment-icon">💳</span>
                                    <span>Carte de crédit</span>
                                </label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" id="payment_paypal" name="payment_method" value="paypal">
                                <label for="payment_paypal">
                                    <span class="payment-icon">🅿️</span>
                                    <span>PayPal</span>
                                </label>
                            </div>
                        </div>
                        
                        <div id="cc-form" class="payment-details" style="display:none;">
                            <div class="form-group">
                                <label for="cc_number">Numéro de carte</label>
                                <input type="text" id="cc_number" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="cc_expiry">Date d'expiration</label>
                                    <input type="text" id="cc_expiry" placeholder="MM/AA">
                                </div>
                                <div class="form-group">
                                    <label for="cc_cvv">CVV</label>
                                    <input type="text" id="cc_cvv" placeholder="123">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                
                <div class="order-summary">
                    <div class="summary-header">
                        <h2>Récapitulatif de commande</h2>
                    </div>
                    
                    <div class="summary-items">
                        <?php foreach ($cart as $item): ?>
                            <div class="summary-item">
                                <div class="item-details">
                                    <span class="item-quantity"><?php echo $item['quantity']; ?> ×</span>
                                    <span class="item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                </div>
                                <span class="item-price"><?php echo number_format($item['subtotal'], 2); ?> €</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="summary-totals">
                        <div class="summary-total-row">
                            <span>Sous-total</span>
                            <span><?php echo number_format($total, 2); ?> €</span>
                        </div>
                        <div class="summary-total-row">
                            <span>Livraison</span>
                            <span>Gratuit</span>
                        </div>
                        <div class="summary-total-row total">
                            <span>Total</span>
                            <span><?php echo number_format($total, 2); ?> €</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="button button-primary checkout-button">Confirmer la commande</button>
                    <a href="?controller=cart&action=view" class="back-to-cart">Retour au panier</a>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Afficher le formulaire de carte de crédit quand l'option est sélectionnée
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const ccForm = document.getElementById('cc-form');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'credit_card') {
                ccForm.style.display = 'block';
            } else {
                ccForm.style.display = 'none';
            }
        });
    });
    
    // Validation du formulaire
    const checkoutForm = document.getElementById('checkout-form');
    
    checkoutForm.addEventListener('submit', function(event) {
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        
        if (!selectedPayment) {
            event.preventDefault();
            alert('Veuillez sélectionner un mode de paiement.');
            return;
        }
        
        // Simulation de paiement pour ce projet MVP
        // Dans un projet réel, cette partie serait remplacée par une intégration avec un service de paiement
        
        if (selectedPayment.value === 'credit_card') {
            const ccNumber = document.getElementById('cc_number').value;
            const ccExpiry = document.getElementById('cc_expiry').value;
            const ccCvv = document.getElementById('cc_cvv').value;
            
            if (!ccNumber || !ccExpiry || !ccCvv) {
                event.preventDefault();
                alert('Veuillez remplir tous les champs de la carte de crédit.');
            }
            // Dans un projet réel, on ferait la validation du format ici
        }
    });
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>