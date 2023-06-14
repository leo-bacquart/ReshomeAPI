FROM php:8.2-fpm

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer