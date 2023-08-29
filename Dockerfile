FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
        libpq-dev \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR "/var/www/html"

COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader

RUN apt-get update && apt-get install -y nginx

COPY docker/nginx/conf.d /etc/nginx/sites-available/default

EXPOSE 80

CMD service nginx start && php-fpm
