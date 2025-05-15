FROM php:8.1-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git unzip zip libpq-dev libicu-dev libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install intl pdo pdo_pgsql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer le dossier de travail
WORKDIR /var/www/html

# Copier le code source de l'application
COPY . /var/www/html

# Corriger le problème Git de "dubious ownership"
RUN git config --global --add safe.directory /var/www/html

# Fix Git warning
RUN git config --global --add safe.directory /var/www/html

# Installer les dépendances PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
