-- Structure de la base de données pour Cooldown Store

-- Supprimer les tables si elles existent
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des catégories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des produits
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NOT NULL,
    category_id INT NOT NULL,
    featured TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Table des commandes
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
    shipping_address VARCHAR(255) NOT NULL,
    shipping_city VARCHAR(100) NOT NULL,
    shipping_zip VARCHAR(20) NOT NULL,
    shipping_country VARCHAR(50) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des éléments de commande
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Insérer un utilisateur admin
INSERT INTO users (name, email, password, role, created_at) VALUES
('Admin', 'admin@cooldown-store.com', '$2y$10$g5A9lZ0JBiLQaP1GFGFzZ.1HzUAImBsEjdR9D3rvQ1h5lROvTI/m.', 'admin', NOW());
-- Mot de passe: admin123

-- Insérer quelques catégories
INSERT INTO categories (name, image) VALUES
('PC', 'pc.jpg'),
('Xbox', 'xbox.jpg'),
('PlayStation', 'playstation.jpg'),
('Nintendo', 'nintendo.jpg');

-- Insérer quelques produits
INSERT INTO products (name, description, price, stock, image, category_id, featured, created_at) VALUES
('Cyberpunk 2077', 'Cyberpunk 2077 est un RPG d''action-aventure en monde ouvert qui se déroule à Night City, une mégalopole obsédée par le pouvoir, la séduction et les modifications corporelles.', 59.99, 50, 'cyberpunk.jpg', 1, 1, NOW()),
('FIFA 23', 'EA SPORTS FIFA 23 vous rapproche du football que vous aimez grâce aux avancées technologiques qui définissent l''avenir du jeu.', 69.99, 100, 'fifa23.jpg', 2, 1, NOW()),
('The Last of Us Part II', 'Cinq ans après leur voyage périlleux à travers une Amérique ravagée par la pandémie, Ellie et Joel se sont installés à Jackson, Wyoming.', 49.99, 30, 'lastofus2.jpg', 3, 1, NOW()),
('Animal Crossing: New Horizons', 'Échappez-vous sur une île déserte et construisez votre petit paradis dans le jeu Animal Crossing: New Horizons sur Nintendo Switch.', 54.99, 80, 'animalcrossing.jpg', 4, 1, NOW()),
('Minecraft', 'Minecraft est un jeu qui vous permet de placer des blocs et de partir à l''aventure.', 29.99, 200, 'minecraft.jpg', 1, 0, NOW()),
('Halo Infinite', 'Quand tout espoir est perdu et que le destin de l''humanité est en jeu, le Master Chief est prêt à affronter son ennemi le plus redoutable à ce jour.', 59.99, 45, 'halo.jpg', 2, 0, NOW()),
('God of War Ragnarök', 'Embarquez avec Kratos et Atreus pour un voyage épique à la recherche de réponses avant le Ragnarök prophétisé.', 69.99, 60, 'godofwar.jpg', 3, 0, NOW()),
('The Legend of Zelda: Tears of the Kingdom', 'La suite très attendue du jeu The Legend of Zelda: Breath of the Wild.', 59.99, 40, 'zelda.jpg', 4, 0, NOW());