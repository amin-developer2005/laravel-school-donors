FROM ubuntu:latest
LABEL authors="Administrator"

# مرحله Composer
FROM composer:latest AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# مرحله Node/Vite برای build assets (Filament)
FROM node:20-alpine AS node
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources
RUN npm ci && npm run build

# مرحله نهایی (PHP ساده با artisan serve – برای شروع عالیه)
FROM php:8.3-cli-alpine

# نصب اکستنشن‌های لازم
RUN apk add --no-cache \
    php-pgsql php-bcmath php-ctype php-fileinfo php-mbstring php-openssl php-pdo php-tokenizer php-xml php-curl php-zip \
    && docker-php-ext-install pdo_pgsql  # اگه MySQL داری، pdo_mysql بگذار

WORKDIR /var/www/html

# کپی vendor و assets build شده
COPY --from=composer /app/vendor ./vendor
COPY --from=node /app/public/build ./public/build

# کپی بقیه کد پروژه
COPY . .

# لینک storage، کش‌ها و Filament assets
RUN php artisan storage:link \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan filament:assets

# پورت Render (متغیر محیطی PORT که Render خودش می‌ده)
ENV PORT=10000
EXPOSE $PORT

# شروع اپ با artisan serve (ساده و سریع برای پروداکشن کوچک)
CMD php artisan serve --host=0.0.0.0 --port=$PORT
