# ==========================================
# Stage 1: Composer (Installation des dépendances PHP)
# ==========================================
FROM composer:2 AS composer
WORKDIR /app
# On copie uniquement les fichiers nécessaires à l'installation pour profiter du cache Docker
COPY composer.json composer.lock ./
# Installation SANS les dépendances de développement (optimisation)
RUN composer install --no-dev --no-interaction --prefer-dist --ignore-platform-reqs

# ==========================================
# Stage 2: Assets (Compilation du design avec NPM/Vite)
# ==========================================
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
# On copie le reste pour pouvoir compiler le CSS/JS
COPY . .
RUN npm run build

# ==========================================
# Stage 3: Runner PHP-FPM (L'image finale ultra légère)
# ==========================================
FROM php:8.2-fpm-alpine AS runner
WORKDIR /var/www/html

# Installation des extensions PHP requises par Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Récupération des dossiers vitaux depuis les stages précédents
COPY --from=composer /app/vendor/ ./vendor/
COPY --from=assets /app/public/build/ ./public/build/

# Copie du reste du code de l'application
COPY . .

# Attribution des permissions au serveur web (crucial pour Laravel)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]