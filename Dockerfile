# ============================================================
# Stage 1: Node.js — build frontend assets
# ============================================================
FROM node:20-alpine AS frontend

WORKDIR /app

# Copy package files and install dependencies
COPY package.json package-lock.json ./
RUN npm ci

# Copy source files needed for the Vite build
COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

# Build production assets
RUN npm run build

# ============================================================
# Stage 2: PHP — Laravel application
# ============================================================
FROM php:8.2-cli-alpine AS app

# Install system dependencies and PHP extensions required by Laravel
RUN apk add --no-cache \
        bash \
        curl \
        git \
        unzip \
        libpng-dev \
        libjpeg-turbo-dev \
        libwebp-dev \
        freetype-dev \
        oniguruma-dev \
        libxml2-dev \
        mysql-client \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        xml \
        ctype \
        bcmath \
        gd \
        opcache \
        pcntl \
        fileinfo

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files and install PHP dependencies (no dev)
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --optimize-autoloader \
        --no-scripts

# Copy the full application source
COPY . .

# Copy compiled frontend assets from the frontend stage
COPY --from=frontend /app/public/build ./public/build

# Run composer scripts that require the full app to be present
RUN composer run-script post-autoload-dump --no-interaction

# Create the .env file from the example if one is not present at runtime,
# and ensure storage/bootstrap directories are writable
RUN mkdir -p storage/framework/{sessions,views,cache/data} \
             storage/logs \
             bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Create .env from example so Laravel can read environment variables
RUN cp .env.example .env || true

# Expose the port PHP's built-in server will listen on
EXPOSE 8000

# Entrypoint: generate app key if missing, run migrations, cache config, then serve
# Use semicolons with individual fallbacks so the PHP server always starts
CMD php artisan key:generate --no-interaction --force 2>/dev/null || true; \
    php artisan migrate --force --no-interaction || echo "Migration failed, continuing..."; \
    php artisan config:cache || true; \
    php artisan route:cache || true; \
    php artisan view:cache || true; \
    php -S 0.0.0.0:${PORT:-8000} -t public
