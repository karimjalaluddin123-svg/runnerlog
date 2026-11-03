FROM php:8.2-apache

RUN apt-get update && apt-get install -y libonig-dev libpng-dev libzip-dev zip unzip git \
    && docker-php-ext-install pdo_mysql mbstring gd zip \
    && a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && chown -R www-data:www-data storage bootstrap/cache public \
    && sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

CMD if [ -z "$APP_KEY" ]; then \
      if [ ! -f storage/app/.runnerlog-key ]; then php -r 'echo "base64:" . base64_encode(random_bytes(32));' > storage/app/.runnerlog-key; fi; \
      export APP_KEY="$(cat storage/app/.runnerlog-key)"; \
    fi; \
    if [ -n "$RENDER_EXTERNAL_URL" ]; then export APP_URL="$RENDER_EXTERNAL_URL"; fi; \
    export APP_DEBUG=false APP_ENV=production SESSION_DRIVER=file CACHE_STORE=file QUEUE_CONNECTION=sync; \
    chown -R www-data:www-data storage bootstrap/cache; chmod -R ug+rw storage bootstrap/cache; \
    php artisan config:clear; php artisan config:cache; php artisan route:cache; php artisan view:cache; \
    php artisan migrate --force; apache2-foreground
EXPOSE 80
