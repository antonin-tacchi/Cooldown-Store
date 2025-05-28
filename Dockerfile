# Image de base PHP 8.2 avec Apache
FROM php:8.2-apache

# Met à jour les packages et installe les dépendances système
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Active les modules Apache nécessaires
RUN a2enmod rewrite
RUN a2enmod headers

# Installe les extensions PHP nécessaires
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    zip

# Configure Apache pour pointer vers la racine du projet (pas public/)
RUN sed -ri -e 's!/var/www/html!/var/www!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!DocumentRoot /var/www/html!DocumentRoot /var/www!g' /etc/apache2/sites-available/*.conf

# Configure les permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www

# Expose le port 80
EXPOSE 80