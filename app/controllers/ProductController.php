<?php

class ProductController {
    private $productModel;
    private $categoryModel;
    
    public function __construct() {
        require_once 'app/models/Product.php';
        require_once 'app/models/Category.php';
        
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }
    
    // Afficher la liste des produits
    public function list() {
        $categoryId = isset($_GET['category']) ? $_GET['category'] : null;
        
        // Récupérer les produits
        $products = $this->productModel->getAllProducts($categoryId);
        
        // Récupérer toutes les catégories
        $categories = $this->categoryModel->getAllCategories();
        
        // Récupérer le nom de la catégorie actuelle si elle est définie
        $currentCategory = null;
        if ($categoryId) {
            $currentCategory = $this->categoryModel->getCategoryById($categoryId);
        }
        
        // Charger la vue
        require_once 'app/views/product/list.php';
    }
    
    // Afficher le détail d'un produit
    public function detail() {
        if (!isset($_GET['id'])) {
            header('Location: index.php');
            exit;
        }
        
        $productId = $_GET['id'];
        
        // Récupérer le produit
        $product = $this->productModel->getProductById($productId);
        
        if (!$product) {
            header('Location: index.php');
            exit;
        }
        
        // Récupérer la catégorie du produit
        $category = $this->categoryModel->getCategoryById($product['category_id']);
        
        // Charger la vue
        require_once 'app/views/product/detail.php';
    }
    
    // Rechercher des produits (pour la barre de recherche)
    public function search() {
        header('Content-Type: application/json');
        
        if (!isset($_GET['q']) || empty($_GET['q'])) {
            echo json_encode([]);
            exit;
        }
        
        $keyword = $_GET['q'];
        
        // Rechercher des produits
        $products = $this->productModel->searchProducts($keyword);
        
        echo json_encode($products);
        exit;
    }
}