FROM php:8.4-apache

# Устанавливаем зависимости для SOAP
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
    libxml2-dev \
    libonig-dev \
    && docker-php-ext-install soap \
    && docker-php-ext-install json \
    && docker-php-ext-install mbstring

# Опционально: настраиваем Apache корень, если нужно
ENV APACHE_DOCUMENT_ROOT=/var/www/html

RUN mkdir -p /var/log/4sides && \
    chown -R www-data:www-data /var/log/4sides && \
    chmod -R 775 /var/log/4sides

# Копируем кастомный apache config, если хочешь использовать .htaccess
# RUN a2enmod rewrite