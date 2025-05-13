<?php require_once 'app/views/layouts/header.php'; ?>

<main class="product-list-page">
    <div class="container">
        <!-- Bannière de catégorie si une catégorie est sélectionnée -->
        <?php if ($currentCategory): ?>
            <div class="category-banner">
                <h1><?php echo htmlspecialchars($currentCategory['name']); ?></h1>
            </div>
        <?php else: ?>
            <div class="page-title">
                <h1>Tous nos produits</h1>
            </div>
        <?php endif; ?>
        
        <div class="products-container">
            <!-- Sidebar avec filtres -->
            <aside class="filters-sidebar">
                <h2>Catégories</h2>
                <ul class="category-list">
                    <li>
                        <a href="?controller=product&action=list" class="<?php echo !isset($_GET['category']) ? 'active' : ''; ?>">Tous les produits</a>
                    </li>
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="?controller=product&action=list&category=<?php echo $category['id']; ?>" 
                               class="<?php echo (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                
                <h2>Prix</h2>
                <div class="price-filter">
                    <input type="range" id="price-range" min="0" max="100" value="100" class="price-slider">
                    <div class="price-range-display">
                        <span>0€</span>
                        <span id="max-price-display">100€</span>
                    </div>
                </div>
                
                <button id="apply-filters" class="button button-primary">Appliquer les filtres</button>
            </aside>
            
            <!-- Liste des produits -->
            <div class="products-grid">
                <?php if (empty($products)): ?>
                    <div class="no-products">
                        <p>Aucun produit trouvé.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card" data-price="<?php echo $product['price']; ?>">
                            <div class="product-image">
                                <img src="./public/assets/image/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="product-price"><?php echo number_format($product['price'], 2); ?> €</p>
                                <div class="product-actions">
                                    <a href="?controller=product&action=detail&id=<?php echo $product['id']; ?>" class="button button-secondary">Voir</a>
                                    <button class="button button-primary add-to-cart" data-id="<?php echo $product['id']; ?>">Ajouter au panier</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
// Code JavaScript pour le filtrage côté client
document.addEventListener('DOMContentLoaded', function() {
    const priceRange = document.getElementById('price-range');
    const maxPriceDisplay = document.getElementById('max-price-display');
    const applyFiltersBtn = document.getElementById('apply-filters');
    const productCards = document.querySelectorAll('.product-card');
    
    // Mise à jour de l'affichage du prix maximum
    priceRange.addEventListener('input', function() {
        maxPriceDisplay.textContent = this.value + '€';
    });
    
    // Application des filtres de prix
    applyFiltersBtn.addEventListener('click', function() {
        const maxPrice = parseInt(priceRange.value);
        
        productCards.forEach(card => {
            const price = parseFloat(card.dataset.price);
            
            if (price <= maxPrice) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>