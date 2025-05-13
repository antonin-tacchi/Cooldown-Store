<?php

class CartController {
    private $productModel;
    
    public function __construct() {
        require_once 'app/models/Product.php';
        require_once 'core/Session.php';
        
        $this->productModel = new Product();
        Session::start();
        
        // Initialiser le panier si nécessaire
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }
    
    // Afficher le panier
    public function view() {
        $cart = [];
        $total = 0;
        
        // Récupérer les détails des produits dans le panier
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $product = $this->productModel->getProductById($item['product_id']);
                
                if ($product) {
                    $subtotal = $product['price'] * $item['quantity'];
                    $cart[] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image' => $product['image'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal
                    ];
                    
                    $total += $subtotal;
                }
            }
        }
        
        // Charger la vue
        require_once 'app/views/cart/cart.php';
    }
    
    // Ajouter un produit au panier
    public function add() {
        header('Content-Type: application/json');
        
        // Vérifier les données
        if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
            echo json_encode(['success' => false, 'message' => 'Données invalides']);
            exit;
        }
        
        $productId = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        
        // Vérifier si le produit existe
        $product = $this->productModel->getProductById($productId);
        
        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Produit non trouvé']);
            exit;
        }
        
        // Vérifier le stock
        if ($product['stock'] < $quantity) {
            echo json_encode(['success' => false, 'message' => 'Stock insuffisant']);
            exit;
        }
        
        // Ajouter au panier
        $found = false;
        
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] === $productId) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $_SESSION['cart'][] = [
                'product_id' => $productId,
                'quantity' => $quantity
            ];
        }
        
        // Calculer le nombre total d'articles
        $cartCount = array_reduce($_SESSION['cart'], function($total, $item) {
            return $total + $item['quantity'];
        }, 0);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Produit ajouté au panier', 
            'cartCount' => $cartCount
        ]);
        exit;
    }
    
    // Mettre à jour la quantité d'un produit
    public function update() {
        header('Content-Type: application/json');
        
        // Vérifier les données
        if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
            echo json_encode(['success' => false, 'message' => 'Données invalides']);
            exit;
        }
        
        $productId = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        
        // Vérifier la quantité
        if ($quantity <= 0) {
            echo json_encode(['success' => false, 'message' => 'Quantité invalide']);
            exit;
        }
        
        // Vérifier le stock
        $product = $this->productModel->getProductById($productId);
        
        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Produit non trouvé']);
            exit;
        }
        
        if ($product['stock'] < $quantity) {
            echo json_encode(['success' => false, 'message' => 'Stock insuffisant']);
            exit;
        }
        
        // Mettre à jour la quantité
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] === $productId) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        
        echo json_encode(['success' => true, 'message' => 'Panier mis à jour']);
        exit;
    }
    
    // Supprimer un produit du panier
    public function remove() {
        header('Content-Type: application/json');
        
        // Vérifier les données
        if (!isset($_POST['product_id'])) {
            echo json_encode(['success' => false, 'message' => 'Données invalides']);
            exit;
        }
        
        $productId = (int)$_POST['product_id'];
        
        // Supprimer du panier
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] === $productId) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        
        // Réindexer le tableau
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        
        echo json_encode(['success' => true, 'message' => 'Produit supprimé du panier']);
        exit;
    }
    
    // Vider le panier
    public function clear() {
        $_SESSION['cart'] = [];
        
        header('Location: ?controller=cart&action=view');
        exit;
    }
    
    // Afficher la page de validation de commande
    public function checkout() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            // Rediriger vers la page de connexion
            header('Location: ?controller=user&action=login&redirect=checkout');
            exit;
        }
        
        // Vérifier si le panier est vide
        if (empty($_SESSION['cart'])) {
            header('Location: ?controller=cart&action=view');
            exit;
        }
        
        // Récupérer les infos du panier
        $cart = [];
        $total = 0;
        
        foreach ($_SESSION['cart'] as $item) {
            $product = $this->productModel->getProductById($item['product_id']);
            
            if ($product) {
                $subtotal = $product['price'] * $item['quantity'];
                $cart[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal
                ];
                
                $total += $subtotal;
            }
        }
        
        // Charger la vue
        require_once 'app/views/cart/checkout.php';
    }
    
    // Traiter la commande
    public function processOrder() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?controller=user&action=login&redirect=checkout');
            exit;
        }
        
        // Vérifier si le panier est vide
        if (empty($_SESSION['cart'])) {
            header('Location: ?controller=cart&action=view');
            exit;
        }
        
        // Vérifier les données du formulaire
        if (!isset($_POST['payment_method']) || empty($_POST['payment_method'])) {
            // Rediriger vers la page de paiement avec un message d'erreur
            // ...
            header('Location: ?controller=cart&action=checkout&error=payment');
            exit;
        }
        
        // Simulation de la création de commande (à implémenter avec le modèle Order dans un projet réel)
        // ...
        
        // Vider le panier après la commande
        $_SESSION['cart'] = [];
        
        // Rediriger vers une page de confirmation
        header('Location: ?controller=cart&action=confirmation');
        exit;
    }
    
    // Afficher la page de confirmation
    public function confirmation() {
        require_once 'app/views/cart/confirmation.php';
    }
}