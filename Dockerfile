# مرحله Composer (همون قبلی)
FROM composer:latest AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# مرحله Node/Vite – اینجا تغییر اصلی: node:20 به جای alpine
FROM node:20 AS node
WORKDIR /app

# اول packageها برای caching
COPY package*.json ./
RUN npm ci

# بعد همه کد
COPY . .

# حالا build – vite درست پیدا می‌شه
RUN npm run build

# مرحله نهایی (PHP)
FROM php:8.3-cli-alpine

RUN apk add --no-cache \
    php-pgsql php-bcmath php-ctype php-fileinfo php-mbstring php-openssl php-pdo php-tokenizer php-xml php-curl php-zip \
    && docker-php-ext-install pdo_pgsql  # اگه MySQL، pdo_mysql

WORKDIR /var/www/html

COPY --from=composer /app/vendor ./vendor
COPY --from=node /app/public/build ./public/build
COPY . .

RUN php artisan storage:link \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan filament:assets

ENV PORT=10000
EXPOSE $PORT

CMD php artisan serve --host=0.0.0.0 --port=$PORT
