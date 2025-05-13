-- Base de données : `cooldown_store`
--

-- --------------------------------------------------------

--
-- Structure de la table `carousel_images`
--

DROP TABLE IF EXISTS `carousel_images`;
CREATE TABLE IF NOT EXISTS `carousel_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `carousel_images`
--

INSERT INTO `carousel_images` (`id`, `image`, `title`, `link`, `active`, `position`, `created_at`, `updated_at`) VALUES
(1, 'cyberpunk2077.jpg', 'Cyberpunk 2077', '?controller=product&action=detail&id=1', 1, 1, '2025-05-13 08:49:27', '2025-05-13 09:12:22'),
(2, 'fifa-23.jpg', 'FIFA 23', '?controller=product&action=detail&id=2', 1, 2, '2025-05-13 08:49:27', '2025-05-13 09:13:29'),
(3, 'lastofus2.jpg', 'The Last of Us Part II', '?controller=product&action=detail&id=3', 1, 3, '2025-05-13 08:49:27', '2025-05-13 09:14:41'),
(4, 'animalcrossing.jpg', 'Animal Crossing: New Horizons', '?controller=product&action=detail&id=4', 1, 4, '2025-05-13 08:49:27', '2025-05-13 09:14:53'),
(5, 'claireObscure.jpg', 'Clair Obscur: Expedition 33', '?controller=product&action=detail&id=9', 1, 5, '2025-05-13 10:49:22', '2025-05-13 11:01:17');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'PC', 'pc.jpg', '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(2, 'Xbox', 'xbox.jpg', '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(3, 'PlayStation', 'playstation.jpg', '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(4, 'Nintendo', 'nintendo.jpg', '2025-05-12 15:08:24', '2025-05-12 15:08:24');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `shipping_address` varchar(255) NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_zip` varchar(20) NOT NULL,
  `shipping_country` varchar(50) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `category_id`, `featured`, `created_at`, `updated_at`) VALUES
(1, 'Cyberpunk 2077', 'Cyberpunk 2077 est un RPG d\'action-aventure en monde ouvert qui se déroule à Night City, une mégalopole obsédée par le pouvoir, la séduction et les modifications corporelles.', 59.99, 50, 'cyberpunk2077.jpg', 1, 1, '2025-05-12 15:08:24', '2025-05-12 18:02:57'),
(2, 'FIFA 23', 'EA SPORTS FIFA 23 vous rapproche du football que vous aimez grâce aux avancées technologiques qui définissent l\'avenir du jeu.', 69.99, 100, 'fifa-23.jpg', 2, 1, '2025-05-12 15:08:24', '2025-05-12 18:01:38'),
(3, 'The Last of Us Part II', 'Cinq ans après leur voyage périlleux à travers une Amérique ravagée par la pandémie, Ellie et Joel se sont installés à Jackson, Wyoming.', 49.99, 30, 'lastofus2.jpg', 3, 1, '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(4, 'Animal Crossing: New Horizons', 'Échappez-vous sur une île déserte et construisez votre petit paradis dans le jeu Animal Crossing: New Horizons sur Nintendo Switch.', 54.99, 80, 'animalcrossing.jpg', 4, 1, '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(5, 'Minecraft', 'Minecraft est un jeu qui vous permet de placer des blocs et de partir à l\'aventure.', 29.99, 200, 'minecraft.jpg', 1, 0, '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(6, 'Halo Infinite', 'Quand tout espoir est perdu et que le destin de l\'humanité est en jeu, le Master Chief est prêt à affronter son ennemi le plus redoutable à ce jour.', 59.99, 45, 'halo.jpg', 2, 0, '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(7, 'God of War Ragnarök', 'Embarquez avec Kratos et Atreus pour un voyage épique à la recherche de réponses avant le Ragnarök prophétisé.', 69.99, 60, 'godofwar.jpg', 3, 0, '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(8, 'The Legend of Zelda: Tears of the Kingdom', 'La suite très attendue du jeu The Legend of Zelda: Breath of the Wild.', 59.99, 40, 'zelda.jpg', 4, 0, '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(9, 'Clair Obscur: Expedition 33', 'Une fois par an, la Peintresse se réveille. Sur son Monolithe, elle peint son nombre maudit. Et tous ceux de cet âge partent en fumée. Année après année, ce nombre diminue et nous sommes toujours plus nombreux à être effacés. Demain, elle se réveillera pour peindre « 33 ». Et demain, nous partirons pour notre ultime mission : éliminer la Peintresse, pour que plus jamais elle ne peigne la mort.', 29.99, 50, 'claireObscure.jpg', 1, 0, '2025-05-13 08:50:57', '2025-05-13 11:03:02');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@cooldown-store.com', '$2y$10$g5A9lZ0JBiLQaP1GFGFzZ.1HzUAImBsEjdR9D3rvQ1h5lROvTI/m.', 'admin', '2025-05-12 15:08:24', '2025-05-12 15:08:24'),
(2, 'Tacchi antonin', 'antonin.tacchi@laplateforme.io', '$2y$10$vOlMiBIYbr5uQyAaPnm0fOVEvVE3Hh4HOIma30ZXqrbWS/wbdzL/C', 'admin', '2025-05-12 15:25:39', '2025-05-12 15:26:17'),
(3, 'test teste', 'test@gmail.com', '$2y$10$3uCC2NDiHz2gPLdSpcJ8weF8PIIqFMlT1cMTER3PwmdOvgq8.8cbu', 'user', '2025-05-12 17:45:56', '2025-05-12 17:45:56');
COMMIT;