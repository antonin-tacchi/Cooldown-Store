<?php

class OrderModel {
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
    
    /**
     * Récupère toutes les commandes
     * @return array Liste de toutes les commandes
     */
    public function getAllOrders() {
        $query = "SELECT o.*, u.email as user_email 
                 FROM orders o
                 LEFT JOIN users u ON o.user_id = u.id
                 ORDER BY o.created_at DESC";
                 
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupère une commande par son ID
     * @param int $id ID de la commande
     * @return array|bool Données de la commande ou false
     */
    public function getOrderById($id) {
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupère les détails d'une commande
     * @param int $orderId ID de la commande
     * @return array Liste des produits de la commande
     */
    public function getOrderDetails($orderId) {
        $query = "SELECT od.*, p.name as product_name, p.image as product_image 
                 FROM order_details od
                 LEFT JOIN products p ON od.product_id = p.id
                 WHERE od.order_id = :order_id";
                 
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupère les commandes d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @return array Liste des commandes de l'utilisateur
     */
    public function getOrdersByUserId($userId) {
        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Crée une nouvelle commande
     * @param array $orderData Données de la commande
     * @param array $items Produits de la commande
     * @return int|bool ID de la commande créée ou false
     */
    public function createOrder($orderData, $items) {
        $this->db->beginTransaction();
        
        try {
            // Insérer la commande
            $query = "INSERT INTO orders (user_id, total_amount, shipping_address, billing_address, 
                     payment_method, status, created_at) 
                     VALUES (:user_id, :total_amount, :shipping_address, :billing_address, 
                     :payment_method, :status, NOW())";
                     
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $orderData['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(':total_amount', $orderData['total_amount'], PDO::PARAM_STR);
            $stmt->bindParam(':shipping_address', $orderData['shipping_address'], PDO::PARAM_STR);
            $stmt->bindParam(':billing_address', $orderData['billing_address'], PDO::PARAM_STR);
            $stmt->bindParam(':payment_method', $orderData['payment_method'], PDO::PARAM_STR);
            $stmt->bindParam(':status', $orderData['status'], PDO::PARAM_STR);
            $stmt->execute();
            
            $orderId = $this->db->lastInsertId();
            
            // Insérer les détails de la commande
            foreach ($items as $item) {
                $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                         VALUES (:order_id, :product_id, :quantity, :price)";
                         
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                $stmt->bindParam(':price', $item['price'], PDO::PARAM_STR);
                $stmt->execute();
                
                // Mettre à jour le stock
                $query = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
                $stmt->execute();
            }
            
            $this->db->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    /**
     * Mettre à jour le statut d'une commande
     * @param int $orderId ID de la commande
     * @param string $status Nouveau statut
     * @return bool Succès de l'opération
     */
    public function updateOrderStatus($orderId, $status) {
        $query = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Supprimer une commande (principalement pour des besoins administratifs)
     * @param int $orderId ID de la commande
     * @return bool Succès de l'opération
     */
    public function deleteOrder($orderId) {
        $this->db->beginTransaction();
        
        try {
            // Supprimer les détails de la commande
            $query = "DELETE FROM order_details WHERE order_id = :order_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            
            // Supprimer la commande
            $query = "DELETE FROM orders WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    /**
     * Obtenir des statistiques sur les commandes (pour le tableau de bord admin)
     * @return array Statistiques
     */
    public function getOrderStats() {
        $stats = [];
        
        // Nombre total de commandes
        $query = "SELECT COUNT(*) as total FROM orders";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stats['total_orders'] = $result['total'];
        
        // Commandes par statut
        $query = "SELECT status, COUNT(*) as count FROM orders GROUP BY status";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['orders_by_status'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Chiffre d'affaires total
        $query = "SELECT SUM(total_amount) as revenue FROM orders WHERE status != 'cancelled'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stats['total_revenue'] = $result['revenue'];
        
        // Commandes récentes
        $query = "SELECT o.*, u.email as user_email 
                 FROM orders o
                 LEFT JOIN users u ON o.user_id = u.id
                 ORDER BY o.created_at DESC LIMIT 5";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['recent_orders'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $stats;
    }
}