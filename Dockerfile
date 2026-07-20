# استخدام اسم الـ Tag الرسمي السليم لـ FrankenPHP مع PHP 8.4
FROM dunglas/frankenphp:1-php8.4

# 1. تثبيت إضافات PHP التي يحتاجها Laravel
RUN install-php-extensions pdo_mysql gd bcmath zip intl opcache pcntl

# 2. مسار العمل
WORKDIR /app

# 3. نسخ كود المشروع
COPY . /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. تثبيت حزم Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 5. ضبط الصلاحيات للمجلدات التي يكتب عليها Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# 6. تحديد مجلد الـ public كـ Document Root
ENV DOCUMENT_ROOT=/app/public

# فتح البورت
EXPOSE 8080

CMD ["frankenphp", "php-server", "--listen", ":8080", "--root", "/app/public"]