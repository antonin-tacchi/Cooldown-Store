<?php

class HomeController {
    private $productModel;
    private $categoryModel;
    private $carouselModel; // Ajout de la propriété carouselModel
    
    public function __construct() {
        require_once 'app/models/Product.php';
        require_once 'app/models/Category.php';
        require_once 'app/models/CarouselImage.php'; // Inclusion du modèle CarouselImage
        
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->carouselModel = new CarouselImage(); // Initialisation du modèle
    }
    
    public function index() {
        // Récupérer les produits en vedette
        $featuredProducts = $this->productModel->getFeaturedProducts();
        
        // Récupérer les derniers produits
        $latestProducts = $this->productModel->getLatestProducts();
        
        // Récupérer les catégories
        $categories = $this->categoryModel->getAllCategories();
        
        // Récupérer les images du carrousel
        $carouselImages = $this->carouselModel->getActiveImages();
        
        // Charger la vue
        require_once 'app/views/home.php';
    }
}