<?php require_once 'app/views/layouts/header.php'; ?>

<main>

    <!-- Bannière principale avec carrousel automatique d'images de jeux vidéo (tous les slides sans active) -->
    <section class="hero-carousel">
        <div class="carousel-container">
            <div class="carousel-slides">
                <?php if (!empty($carouselImages)): ?>
                    <?php foreach ($carouselImages as $index => $carouselImage): ?>
                        <div class="carousel-slide" data-index="<?php echo $index; ?>">
                            <?php if (!empty($carouselImage['link'])): ?>
                                <a href="<?php echo htmlspecialchars($carouselImage['link']); ?>">
                            <?php endif; ?>
                            
                            <img src="./public/assets/image/products/<?php echo htmlspecialchars($carouselImage['image']); ?>" 
                                alt="<?php echo htmlspecialchars($carouselImage['title']); ?>">
                            
                            <?php if (!empty($carouselImage['link'])): ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Produits en vedette -->
    <section class="featured-products">
        <h2>Produits en vedette</h2>
        <div class="products-grid">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="product-card">
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
        </div>
    </section>
    
    <!-- Derniers produits -->
    <section class="latest-products">
        <h2>Nouveautés</h2>
        <div class="products-grid">
            <?php foreach ($latestProducts as $product): ?>
                <div class="product-card">
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
        </div>
    </section>
    
    <!-- Catégories -->
    <section class="categories">
        <h2>Parcourir par catégorie</h2>
        <div class="categories-grid">
            <?php foreach ($categories as $category): ?>
                <a href="?controller=product&action=list&category=<?php echo $category['id']; ?>" class="category-card">
                    <img src="./public/assets/image/categories/<?php echo htmlspecialchars($category['image']); ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                    <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php require_once 'app/views/layouts/footer.php'; ?>