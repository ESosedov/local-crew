FROM composer:2.3.8 as composer_build

WORKDIR /app
COPY . /app
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs --no-interaction --no-scripts --prefer-dist \
    && composer require annotations

FROM php:8.0-apache
ENV APP_HOME /var/www/html
COPY --from=composer_build /app/ /var/www/html/
RUN sed -i -e "s/html/html\/public/g" /etc/apache2/sites-enabled/000-default.conf \
    && usermod -u 1000 www-data && groupmod -g 1000 www-data \
    && chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && sed -i "s/80/\${PORT}/g" /etc/apache2/sites-enabled/000-default.conf /etc/apache2/ports.conf
ENTRYPOINT []
CMD docker-php-entrypoint apache2-foreground
