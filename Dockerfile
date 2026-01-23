FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libpq-dev \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_pgsql \
        gd \
    && rm -rf /var/lib/apt/lists/*

CMD ["php-fpm"]    


























# FROM php:8.2-fpm

# RUN apt-get update && apt-get install -y \
#     git curl zip unzip \
#     libpng-dev libonig-dev libxml2-dev \
#     libzip-dev libjpeg-dev libfreetype6-dev \
#     libpq-dev \
#     && docker-php-ext-install \
#         pdo pdo_pgsql mbstring exif pcntl bcmath gd zip

# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
#     && apt-get install -y nodejs

# WORKDIR /var/www

# COPY . .

# RUN composer install --no-interaction --prefer-dist
# RUN npm install

# RUN chown -R www-data:www-data storage bootstrap/cache

# EXPOSE 9000
# CMD ["php-fpm"]
