<?php require_once 'app/views/layouts/header.php'; ?>

<main class="product-detail-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Accueil</a> &gt; 
            <a href="?controller=product&action=list">Produits</a> &gt; 
            <a href="?controller=product&action=list&category=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a> &gt; 
            <span><?php echo htmlspecialchars($product['name']); ?></span>
        </div>
        
        <div class="product-detail">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="./public/assets/image/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
            </div>
            
            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="product-meta">
                    <span class="product-category">Catégorie: <?php echo htmlspecialchars($category['name']); ?></span>
                    <span class="product-stock <?php echo $product['stock'] > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                        <?php echo $product['stock'] > 0 ? 'En stock' : 'Rupture de stock'; ?>
                    </span>
                </div>
                
                <div class="product-price">
                    <span><?php echo number_format($product['price'], 2); ?> €</span>
                </div>
                
                <div class="product-description">
                    <h2>Description</h2>
                    <div class="description-content">
                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                    </div>
                </div>
                
                <div class="product-actions">
                    <div class="quantity-selector">
                        <button class="quantity-btn minus">-</button>
                        <input type="number" id="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                        <button class="quantity-btn plus">+</button>
                    </div>
                    
                    <button class="button button-primary add-to-cart" data-id="<?php echo $product['id']; ?>" <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>
                        Ajouter au panier
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sélecteurs de quantité
    const quantityInput = document.getElementById('quantity');
    const minusBtn = document.querySelector('.quantity-btn.minus');
    const plusBtn = document.querySelector('.quantity-btn.plus');
    const addToCartBtn = document.querySelector('.add-to-cart');
    const maxStock = <?php echo $product['stock']; ?>;
    
    // Fonction pour vérifier et mettre à jour le bouton d'ajout au panier
    function updateAddToCartButton() {
        if (maxStock <= 0) {
            addToCartBtn.disabled = true;
            addToCartBtn.textContent = 'Rupture de stock';
        }
    }
    
    // Initialiser l'état du bouton
    updateAddToCartButton();
    
    // Diminuer la quantité
    minusBtn.addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        if (value > 1) {
            quantityInput.value = value - 1;
        }
    });
    
    // Augmenter la quantité
    plusBtn.addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        if (value < maxStock) {
            quantityInput.value = value + 1;
        }
    });
    
    // Ajout au panier
    addToCartBtn.addEventListener('click', function() {
        const productId = this.dataset.id;
        const quantity = parseInt(quantityInput.value);
        
        // Appel AJAX pour ajouter au panier
        fetch('?controller=cart&action=add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Produit ajouté au panier !');
                // Mettre à jour l'affichage du panier
                // ...
            } else {
                alert('Erreur : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    });
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>