// JavaScript pour la gestion du panier
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du panier
    const cartIcon = document.querySelector('.cart-icon');
    const cartMenu = document.getElementById('cart-menu');
    const closeCartBtn = document.getElementById('close-cart');
    const overlay = document.getElementById('overlay');
    const cartContent = document.querySelector('.cart-content');
    
    // Boutons d'ajout au panier
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    // Fonction pour rediriger vers la page du panier
    function goToCartPage() {
        window.location.href = '?controller=cart&action=view';
    }
    
    // Ces fonctions ne sont plus nécessaires puisque nous redirigeons vers une page
    // mais nous les gardons au cas où d'autres parties du code les utilisent
    function openCart() {
        goToCartPage();
    }
    
    function closeCart() {
        // Cette fonction n'est plus nécessaire, mais on la garde pour éviter les erreurs
    }
    
    // La fonction updateCartContent n'est plus nécessaire car nous ne l'utilisons plus
    // mais on la garde au cas où d'autres parties du code l'appelleraient
    function updateCartContent() {
        // Cette fonction n'est plus utilisée mais nous la conservons pour éviter des erreurs
        console.log("Cette fonction n'est plus nécessaire car le panier s'ouvre dans une nouvelle page");
    }
    
    // Fonction pour ajouter un produit au panier
    function addToCart(productId, quantity = 1) {
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
                // Rediriger vers la page du panier au lieu d'ouvrir un menu
                goToCartPage();
                
                // Mettre à jour le badge du panier
                updateCartBadge(data.cartCount);
            } else {
                alert('Erreur : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
    }
    
    // Fonction pour supprimer un produit du panier
    function removeFromCart(productId) {
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
                // Mettre à jour le contenu du panier
                updateCartContent();
                
                // Mettre à jour le badge du panier
                updateCartBadge(data.cartCount);
            } else {
                alert('Erreur : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
    }
    
    // Fonction pour mettre à jour le badge du panier
    function updateCartBadge(count) {
        let badge = document.querySelector('.cart-badge');
        
        if (!badge && count > 0) {
            // Créer le badge s'il n'existe pas
            badge = document.createElement('span');
            badge.classList.add('cart-badge');
            cartIcon.parentNode.appendChild(badge);
        }
        
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        }
    }
    
    // Événements
    if (cartIcon) {
        cartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            goToCartPage();
        });
    }
    
    // Ces listeners ne sont plus nécessaires mais nous les gardons
    // au cas où les éléments existent encore dans le DOM
    if (closeCartBtn) {
        closeCartBtn.addEventListener('click', closeCart);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeCart);
    }
    
    // Ajouter des événements aux boutons d'ajout au panier
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            // Récupérer la quantité si elle est disponible (page de détail du produit)
            const quantityInput = document.getElementById('quantity');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            
            addToCart(productId, quantity);
        });
    });
    
    // Initialiser le badge du panier au chargement de la page
    fetch('?controller=cart&action=getCount')
        .then(response => response.json())
        .then(data => {
            if (data.count > 0) {
                updateCartBadge(data.count);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
});