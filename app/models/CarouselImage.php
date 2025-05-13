<?php

class CarouselImage {
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
    
    // Récupérer toutes les images actives du carrousel
    public function getActiveImages() {
        $sql = "SELECT * FROM carousel_images WHERE active = 1 ORDER BY position ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Récupérer une image spécifique par ID
    public function getImageById($id) {
        $sql = "SELECT * FROM carousel_images WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Ajouter une nouvelle image
    public function addImage($data) {
        $sql = "INSERT INTO carousel_images (image, title, link, position, active) 
                VALUES (:image, :title, :link, :position, :active)";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':link', $data['link']);
        $stmt->bindParam(':position', $data['position'], PDO::PARAM_INT);
        $stmt->bindParam(':active', $data['active'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    // Mettre à jour une image
    public function updateImage($id, $data) {
        $sql = "UPDATE carousel_images 
                SET title = :title, 
                    link = :link, 
                    position = :position, 
                    active = :active";
        
        if (!empty($data['image'])) {
            $sql .= ", image = :image";
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':link', $data['link']);
        $stmt->bindParam(':position', $data['position'], PDO::PARAM_INT);
        $stmt->bindParam(':active', $data['active'], PDO::PARAM_INT);
        
        if (!empty($data['image'])) {
            $stmt->bindParam(':image', $data['image']);
        }
        
        return $stmt->execute();
    }
    
    // Supprimer une image
    public function deleteImage($id) {
        $sql = "DELETE FROM carousel_images WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}