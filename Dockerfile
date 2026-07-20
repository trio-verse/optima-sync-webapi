FROM php:8.4-fpm

# 1. تثبيت الحزم الحزم الأساسية للنظام و PHP Extensions المطلوبين لـ Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    cron

RUN apt-get clean && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www


COPY . /var/www


RUN composer install --no-dev --optimize-autoloader --no-interaction


RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache


EXPOSE 9000


CMD ["php-fpm"]