# Multi-stage build voor optimale image size
FROM php:8.3-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    postgresql-dev \
    postgresql-client \
    bash \
    nginx \
    supervisor \
    icu-dev

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    opcache

# Configure opcache
RUN echo "opcache.enable_cli=1" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.interned_strings_buffer=16" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Build stage
FROM base AS builder

WORKDIR /var/www

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies (skip scripts because artisan file doesn't exist yet)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy application files
COPY . .

# Run composer scripts now that artisan exists
RUN composer dump-autoload --optimize --no-interaction

# Build frontend assets
RUN apk add --no-cache nodejs npm && \
    npm install && \
    npm run build && \
    rm -rf node_modules

# Production stage
FROM base AS production

WORKDIR /var/www

# Copy application from builder
COPY --from=builder /var/www /var/www
COPY --chown=www-data:www-data . /var/www

# Set permissions
RUN chmod -R 755 /var/www/storage && \
    chmod -R 755 /var/www/bootstrap/cache

# Configure nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/http.d/default.conf

# Configure supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configure PHP
COPY docker/php.ini /usr/local/etc/php/php.ini

# Copy startup script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8000

CMD ["/start.sh"]

