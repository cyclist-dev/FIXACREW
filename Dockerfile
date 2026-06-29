FROM php:8.2-apache

# Instalar extensões necessárias e o Composer
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && a2enmod rewrite

# Mudar a raiz do Apache para a pasta public do seu projeto
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar os arquivos do projeto
COPY . .

# Instalar dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Ajustar permissões para o Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80