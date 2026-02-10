FROM php:8.3-fpm

# نصب dependencies سیستم و اکستنشن‌ها (از قبل اضافه کردی intl, zip, gd)
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip git curl libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql zip bcmath intl \
    && docker-php-ext-enable gd intl

# نصب Node.js و npm (برای Vite/Filament)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# نصب dependencies بدون تداخل
RUN composer install --optimize-autoloader --no-dev

RUN npm ci && npm run build

RUN php artisan filament:upgrade && php artisan optimize && php artisan storage:link

CMD ["php-fpm"]
