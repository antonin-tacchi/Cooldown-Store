<?php
class AdminController {
    private $productModel;
    private $categoryModel;
    private $userModel;
    private $orderModel; // Cette variable reste inchangée
    private $carouselModel;
    
    public function __construct() {
        require_once 'app/models/Product.php';
        require_once 'app/models/Category.php';
        require_once 'app/models/User.php';
        require_once 'app/models/OrderModel.php'; // Changé de Order.php à OrderModel.php
        require_once 'app/models/CarouselImage.php';
        require_once 'core/Auth.php';
        
        // Vérifier que l'utilisateur est admin
        Auth::requireAdmin();
        
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->userModel = new User();
        $this->orderModel = new OrderModel(); // Changé de Order à OrderModel
        $this->carouselModel = new CarouselImage();
    }
    
    // Tableau de bord admin
    public function dashboard() {
        require_once 'app/views/admin/dashboard.php';
    }
    
    // Gestion des produits
    public function products() {
        $products = $this->productModel->getAllProducts();
        require_once 'app/views/admin/products.php';
    }
    
    // Afficher le formulaire d'ajout de produit
    public function addProduct() {
        // Récupérer toutes les catégories pour le select
        $categories = $this->categoryModel->getAllCategories();
        
        // Charger la vue
        require_once 'app/views/admin/add_product.php';
    }
    
    // Traiter l'ajout du produit
    public function doAddProduct() {
        // Vérifier que les champs obligatoires sont remplis
        if (empty($_POST['name']) || empty($_POST['price']) || empty($_POST['description']) || 
            empty($_POST['stock']) || empty($_POST['category_id'])) {
            
            header('Location: ?controller=admin&action=addProduct&error=missing_fields');
            exit;
        }
        
        // Préparer les données du produit
        $productData = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => (float)$_POST['price'],
            'stock' => (int)$_POST['stock'],
            'category_id' => (int)$_POST['category_id'],
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'image' => !empty($_POST['image']) ? $_POST['image'] : 'default-product.jpg' // Utiliser une image par défaut si aucune n'est fournie
        ];
        
        // Ajouter le produit à la base de données
        try {
            $result = $this->productModel->addProduct($productData);
            
            if ($result) {
                header('Location: ?controller=admin&action=products&success=product_added');
                exit;
            } else {
                header('Location: ?controller=admin&action=addProduct&error=add_failed');
                exit;
            }
        } catch (Exception $e) {
            // Log l'erreur (pour un système en production)
            // error_log($e->getMessage());
            
            header('Location: ?controller=admin&action=addProduct&error=add_failed');
            exit;
        }
    }
    
    // Formulaire de modification de produit
    public function editProduct() {
        if (!isset($_GET['id'])) {
            header('Location: ?controller=admin&action=products');
            exit;
        }
        
        $productId = $_GET['id'];
        $product = $this->productModel->getProductById($productId);
        
        if (!$product) {
            header('Location: ?controller=admin&action=products');
            exit;
        }
        
        $categories = $this->categoryModel->getAllCategories();
        require_once 'app/views/admin/edit_product.php';
    }
    
    // Traiter la modification de produit
    public function doEditProduct() {
        // Vérifier les données
        if (!isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['description']) || !isset($_POST['price']) || !isset($_POST['stock']) || !isset($_POST['category_id'])) {
            header('Location: ?controller=admin&action=products&error=missing_fields');
            exit;
        }
        
        $productId = $_POST['id'];
        
        // Préparer les données
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => (float)$_POST['price'],
            'stock' => (int)$_POST['stock'],
            'category_id' => (int)$_POST['category_id'],
            'featured' => isset($_POST['featured']) ? 1 : 0
        ];
        
        // Traiter l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = 'public/assets/image/products/';
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($extension, $allowedExtensions)) {
                $data['image'] = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $data['image']);
                
                // Supprimer l'ancienne image
                // (à implémenter si nécessaire)
            }
        }
        
        // Mettre à jour le produit
        if ($this->productModel->updateProduct($productId, $data)) {
            header('Location: ?controller=admin&action=products&success=product_updated');
        } else {
            header('Location: ?controller=admin&action=editProduct&id=' . $productId . '&error=update_failed');
        }
        exit;
    }
    
    // Supprimer un produit
    public function deleteProduct() {
        if (!isset($_GET['id'])) {
            header('Location: ?controller=admin&action=products');
            exit;
        }
        
        $productId = $_GET['id'];
        
        if ($this->productModel->deleteProduct($productId)) {
            header('Location: ?controller=admin&action=products&success=product_deleted');
        } else {
            header('Location: ?controller=admin&action=products&error=delete_failed');
        }
        exit;
    }
    
    public function categories() {
        $action = 'categories'; // Ajouter cette ligne
        $categories = $this->categoryModel->getAllCategories();
        require_once 'app/views/admin/categories.php';
    }
    
    // Formulaire d'ajout de catégorie
    public function addCategory() {
        require_once 'app/views/admin/add_category.php';
    }
    
    // Traiter l'ajout de catégorie
    public function doAddCategory() {
        // Vérifier les données
        if (!isset($_POST['name'])) {
            header('Location: ?controller=admin&action=addCategory&error=missing_fields');
            exit;
        }
        
        // Traiter l'image
        $image = 'default-category.jpg'; // Image par défaut
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = 'public/assets/image/categories/';
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($extension, $allowedExtensions)) {
                $image = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
            }
        }
        
        // Préparer les données
        $data = [
            'name' => $_POST['name'],
            'image' => $image
        ];
        
        // Ajouter la catégorie
        if ($this->categoryModel->addCategory($data)) {
            header('Location: ?controller=admin&action=categories&success=category_added');
        } else {
            header('Location: ?controller=admin&action=addCategory&error=add_failed');
        }
        exit;
    }
    
    // Formulaire de modification de catégorie
    public function editCategory() {
        if (!isset($_GET['id'])) {
            header('Location: ?controller=admin&action=categories');
            exit;
        }
        
        $categoryId = $_GET['id'];
        $category = $this->categoryModel->getCategoryById($categoryId);
        
        if (!$category) {
            header('Location: ?controller=admin&action=categories');
            exit;
        }
        
        require_once 'app/views/admin/edit_category.php';
    }
    
    // Traiter la modification de catégorie
    public function doEditCategory() {
        // Vérifier les données
        if (!isset($_POST['id']) || !isset($_POST['name'])) {
            header('Location: ?controller=admin&action=categories&error=missing_fields');
            exit;
        }
        
        $categoryId = $_POST['id'];
        
        // Préparer les données
        $data = [
            'name' => $_POST['name']
        ];
        
        // Traiter l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = 'public/assets/image/categories/';
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($extension, $allowedExtensions)) {
                $data['image'] = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $data['image']);
                
                // Supprimer l'ancienne image
                // (à implémenter si nécessaire)
            }
        }
        
        // Mettre à jour la catégorie
        if ($this->categoryModel->updateCategory($categoryId, $data)) {
            header('Location: ?controller=admin&action=categories&success=category_updated');
        } else {
            header('Location: ?controller=admin&action=editCategory&id=' . $categoryId . '&error=update_failed');
        }
        exit;
    }
    
    // Supprimer une catégorie
    public function deleteCategory() {
        if (!isset($_GET['id'])) {
            header('Location: ?controller=admin&action=categories');
            exit;
        }
        
        $categoryId = $_GET['id'];
        
        if ($this->categoryModel->deleteCategory($categoryId)) {
            header('Location: ?controller=admin&action=categories&success=category_deleted');
        } else {
            header('Location: ?controller=admin&action=categories&error=delete_failed');
        }
        exit;
    }
    
    // Gestion des utilisateurs
    public function users() {
        $users = $this->userModel->getAllUsers();
        require_once 'app/views/admin/users.php';
    }
    
    // Gestion des commandes
    public function orders() {
        $orders = $this->orderModel->getAllOrders();
        require_once 'app/views/admin/orders.php';
    }
    
    // Mettre à jour le statut d'une commande
    public function updateOrderStatus() {
        if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
            header('Location: ?controller=admin&action=orders&error=missing_fields');
            exit;
        }
        
        $orderId = $_POST['order_id'];
        $status = $_POST['status'];
        
        if ($this->orderModel->updateOrderStatus($orderId, $status)) {
            header('Location: ?controller=admin&action=orders&success=status_updated');
        } else {
            header('Location: ?controller=admin&action=orders&error=update_failed');
        }
        exit;
    }
    
    // =============================================
    // GESTION DU CARROUSEL - NOUVELLES MÉTHODES
    // =============================================
    
    // Méthode pour afficher les images du carrousel
    public function carousel() {
        $carouselImages = $this->carouselModel->getActiveImages();
        require_once 'app/views/admin/carousel.php';
    }
    
    // Méthode pour afficher le formulaire d'ajout d'image
    public function addCarouselImage() {
        require_once 'app/views/admin/carousel_form.php';
    }
    
    // Méthode pour traiter l'ajout d'une image au carrousel
    public function doAddCarouselImage() {
        // Vérifier les données
        if (!isset($_POST['title'])) {
            header('Location: ?controller=admin&action=addCarouselImage&error=missing_fields');
            exit;
        }
        
        // Traiter l'image
        $image = '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = 'public/assets/image/products/';
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($extension, $allowedExtensions)) {
                $image = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
            }
        } else {
            header('Location: ?controller=admin&action=addCarouselImage&error=image_required');
            exit;
        }
        
        // Préparer les données
        $data = [
            'image' => $image,
            'title' => $_POST['title'],
            'link' => isset($_POST['link']) ? $_POST['link'] : '',
            'position' => isset($_POST['position']) ? (int)$_POST['position'] : 0,
            'active' => isset($_POST['active']) ? 1 : 0
        ];
        
        // Ajouter l'image
        if ($this->carouselModel->addImage($data)) {
            header('Location: ?controller=admin&action=carousel&success=image_added');
        } else {
            header('Location: ?controller=admin&action=addCarouselImage&error=add_failed');
        }
        exit;
    }
    
    // Méthode pour afficher le formulaire de modification d'image
    public function editCarouselImage() {
        if (!isset($_GET['id'])) {
            header('Location: ?controller=admin&action=carousel');
            exit;
        }
        
        $imageId = $_GET['id'];
        $image = $this->carouselModel->getImageById($imageId);
        
        if (!$image) {
            header('Location: ?controller=admin&action=carousel&error=image_not_found');
            exit;
        }
        
        require_once 'app/views/admin/carousel_form.php';
    }
    
    // Méthode pour traiter la modification d'une image
    public function doEditCarouselImage() {
        // Vérifier les données
        if (!isset($_POST['id']) || !isset($_POST['title'])) {
            header('Location: ?controller=admin&action=carousel&error=missing_fields');
            exit;
        }
        
        $imageId = $_POST['id'];
        
        // Récupérer l'image existante pour vérification
        $existingImage = $this->carouselModel->getImageById($imageId);
        
        if (!$existingImage) {
            header('Location: ?controller=admin&action=carousel&error=image_not_found');
            exit;
        }
        
        // Préparer les données
        $data = [
            'title' => $_POST['title'],
            'link' => isset($_POST['link']) ? $_POST['link'] : '',
            'position' => isset($_POST['position']) ? (int)$_POST['position'] : 0,
            'active' => isset($_POST['active']) ? 1 : 0
        ];
        
        // Traiter la nouvelle image si fournie
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $uploadDir = 'public/assets/image/products/';
            $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($extension, $allowedExtensions)) {
                $data['image'] = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $data['image']);
                
                // Supprimer l'ancienne image si elle existe
                if (!empty($existingImage['image']) && file_exists($uploadDir . $existingImage['image'])) {
                    unlink($uploadDir . $existingImage['image']);
                }
            }
        }
        
        // Mettre à jour l'image
        if ($this->carouselModel->updateImage($imageId, $data)) {
            header('Location: ?controller=admin&action=carousel&success=image_updated');
        } else {
            header('Location: ?controller=admin&action=editCarouselImage&id=' . $imageId . '&error=update_failed');
        }
        exit;
    }
    
    // Méthode pour supprimer une image
    public function deleteCarouselImage() {
        if (!isset($_GET['id'])) {
            header('Location: ?controller=admin&action=carousel');
            exit;
        }
        
        $imageId = $_GET['id'];
        $image = $this->carouselModel->getImageById($imageId);
        
        if (!$image) {
            header('Location: ?controller=admin&action=carousel&error=image_not_found');
            exit;
        }
        
        // Supprimer l'image physique si elle existe
        if (!empty($image['image'])) {
            $imagePath = 'public/assets/image/products/' . $image['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Supprimer l'entrée de la base de données
        if ($this->carouselModel->deleteImage($imageId)) {
            header('Location: ?controller=admin&action=carousel&success=image_deleted');
        } else {
            header('Location: ?controller=admin&action=carousel&error=delete_failed');
        }
        exit;
    }
}