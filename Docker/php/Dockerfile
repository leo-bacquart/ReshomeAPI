FROM php:8.2-fpm

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libssl-dev \
    libcurl4-openssl-dev \
    zlib1g-dev

WORKDIR /var/www

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update -y
RUN apt-get install libyaml-dev -y
RUN  pecl install yaml && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/ext-yaml.ini && docker-php-ext-enable yaml

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions http

RUN echo "upload_max_filesize = 100M;" > /usr/local/etc/php/conf.d/upload.ini
RUN echo "post_max_size = 100M;" >> /usr/local/etc/php/conf.d/upload.ini