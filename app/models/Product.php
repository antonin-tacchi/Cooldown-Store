<?php

class Product {
    private $db;
    
    public function __construct() {
        require_once 'config/config.php';
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 
            DB_USER, 
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    
    // Récupérer tous les produits
    public function getAllProducts($categoryId = null) {
        $sql = "SELECT * FROM products";
        
        if ($categoryId) {
            $sql .= " WHERE category_id = :category_id";
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        
        if ($categoryId) {
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Récupérer les produits en vedette
    public function getFeaturedProducts($limit = 4) {
        $sql = "SELECT * FROM products WHERE featured = 1 ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Récupérer les derniers produits
    public function getLatestProducts($limit = 8) {
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Récupérer un produit par ID
    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Rechercher des produits
    public function searchProducts($keyword) {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT * FROM products WHERE name LIKE :keyword OR description LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Ajouter un produit
    public function addProduct($data) {
        $sql = "INSERT INTO products (name, description, price, image, stock, category_id, featured, created_at) 
                VALUES (:name, :description, :price, :image, :stock, :category_id, :featured, NOW())";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':featured', $data['featured'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    // Mettre à jour un produit
    public function updateProduct($id, $data) {
        $sql = "UPDATE products 
                SET name = :name, 
                    description = :description, 
                    price = :price, 
                    stock = :stock, 
                    category_id = :category_id, 
                    featured = :featured";
        
        if (!empty($data['image'])) {
            $sql .= ", image = :image";
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':featured', $data['featured'], PDO::PARAM_INT);
        
        if (!empty($data['image'])) {
            $stmt->bindParam(':image', $data['image']);
        }
        
        return $stmt->execute();
    }
    
    // Supprimer un produit
    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}