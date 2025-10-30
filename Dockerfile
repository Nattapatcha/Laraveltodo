# ใช้ PHP 8.2-FPM (Alpine Linux) เป็นอิมเมจพื้นฐาน
FROM php:8.2-fpm-alpine

# ตั้งค่า Working Directory
WORKDIR /var/www/html

# ติดตั้ง Dependencies ที่จำเป็นสำหรับ Laravel
RUN apk --no-cache add \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    git \
    curl \
    zip \
    unzip\
    nodejs \  
    npm

# ติดตั้ง PHP Extensions ที่ Laravel ต้องใช้
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mbstring exif pcntl bcmath zip

# ติดตั้ง Composer (ตัวจัดการแพ็กเกจ PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# สร้าง User 'www' สำหรับรัน PHP
RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

# เปลี่ยนเจ้าของไฟล์เป็น www
# (เราจะรัน permission อีกทีตอน start)

# เปลี่ยน User เป็น www
USER www

# เปิด Port 9000 ให้ Nginx คุยด้วย
EXPOSE 9000
CMD ["php-fpm"]