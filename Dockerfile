#FROM composer:2.3.8 as composer_build
#
#WORKDIR /app
#COPY . /app
#RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs --no-interaction --no-scripts --prefer-dist \
#    && composer require annotations
#
#FROM php:8.0-fpm as php_fpm
#RUN apt-get update && apt-get install -y \
#        nginx \
#        libpq-dev \
#        git \
#        curl \
#        libpng-dev \
#        libonig-dev \
#        libxml2-dev \
#        zip \
#        unzip \
#    && docker-php-ext-install -j$(nproc) pgsql \
#    && docker-php-ext-install -j$(nproc) pdo_pgsql \
#    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
#WORKDIR "/var/www/html"
#COPY --from=composer_build /app/ /var/www/html/
#RUN chown -R www-data:www-data /var/www/html
#
#FROM nginx:alpine as nginx
## Копируем конфигурацию Nginx
#COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
## Копируем статические файлы и скрипты Symfony из второго этапа
#COPY --from=php_fpm /var/www/html /var/www/html
#RUN adduser -D -g '' -G www-data www-data \
#    && chown -R www-data:www-data /var/www/html
## Экспонируем порт 80 для доступа к веб-серверу Nginx
#EXPOSE 80
## Запускаем Nginx
#CMD ["nginx", "-g", "daemon off;"]
## Используйте официальный образ PHP-FPM 8.0
##FROM php:8.0-fpm
##
### Обновите системные пакеты и установите необходимые зависимости
##RUN apt-get update && apt-get install -y \
##    nginx \
##    curl \
##    git \
##    libzip-dev \
##    unzip \
##    && rm -rf /var/lib/apt/lists/*
##
### Установите Composer глобально
##RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
##
### Копируйте файлы вашего Symfony-проекта в контейнер
##COPY . /var/www/html/
##
### Установите зависимости Symfony с помощью Composer
##RUN cd /var/www/html/ && composer install --optimize-autoloader --no-dev --ignore-platform-reqs --no-interaction --no-scripts --prefer-dist
##
### Настройте Nginx
##RUN echo "daemon off;" >> /etc/nginx/nginx.conf
##COPY nginx-site.conf /etc/nginx/sites-available/default
##RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/
##
### Экспортируйте порты для PHP-FPM и Nginx
##EXPOSE 9000 80
##
### Запустите PHP-FPM и Nginx
##CMD service php8.0-fpm start && nginx
#

ARG PHP_VERSION=8.0
FROM serversideup/php:${PHP_VERSION}-fpm-nginx-v1.5.0 as base

# PHP_VERSION needs to be repeated here
# See https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION

LABEL fly_launch_runtime="symfony"

RUN apt-get update && apt-get install -y \
    git curl zip unzip rsync ca-certificates vim htop cron \
    php${PHP_VERSION}-pgsql php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-xml php${PHP_VERSION}-mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
# copy application code, skipping files based on .dockerignore
COPY . /var/www/html

RUN composer install --optimize-autoloader --no-dev --no-scripts \
    && chown -R webuser:webgroup /var/www/html \
    && rm -rf /etc/cont-init.d/* \
    && cp .fly/nginx-default /etc/nginx/sites-available/default \
    && cp .fly/entrypoint.sh /entrypoint \
    && cp .fly/FlySymfonyRuntime.php /var/www/html/src/FlySymfonyRuntime.php \
    && chmod +x /entrypoint

ENTRYPOINT ["/entrypoint"]
