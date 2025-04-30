FROM php:8.2-apache

# Agar sizning loyihangizda composer kerak bo‘lsa:
RUN apt-get update && apt-get install -y unzip libzip-dev && docker-php-ext-install zip

# Fayllarni serverga ko‘chirish
COPY . /var/www/html/

# Apache rewrite yoqish
RUN a2enmod rewrite

# Port Railway uchun
EXPOSE 80

# Composer ni yuklash