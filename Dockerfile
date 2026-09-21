# استخدام اسم الـ Tag الرسمي السليم لـ FrankenPHP مع PHP 8.4
FROM dunglas/frankenphp:1-php8.4

# 1. تثبيت إضافات PHP التي يحتاجها Laravel
RUN install-php-extensions pdo_mysql gd bcmath zip intl opcache pcntl

# 2. Runtime required by Spatie Browsershot
RUN apt-get update \
	&& apt-get install -y --no-install-recommends nodejs npm chromium \
	&& rm -rf /var/lib/apt/lists/*

# 3. مسار العمل
WORKDIR /app

# Install production Node dependencies, including Puppeteer.
COPY package.json package-lock.json ./
RUN PUPPETEER_SKIP_DOWNLOAD=true npm ci --omit=dev

# 4. نسخ كود المشروع
COPY . /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. تثبيت حزم Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 6. ضبط الصلاحيات للمجلدات التي يكتب عليها Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# 7. تحديد مجلد الـ public كـ Document Root
ENV DOCUMENT_ROOT=/app/public

# فتح البورت
EXPOSE 8080

CMD ["frankenphp", "php-server", "--listen", ":8080", "--root", "/app/public"]
