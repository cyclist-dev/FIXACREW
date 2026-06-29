FROM php:8.2-apache

# Instala extensões necessárias para MySQL/PDO
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilita mod_rewrite para as rotas do MVC funcionarem
RUN a2enmod rewrite

# Copia todos os arquivos do projeto para dentro do container
COPY . /var/www/html/

# Como seu ponto de entrada é /public, aponta o Apache para lá
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Permissões corretas
RUN chown -R www-data:www-data /var/www/html

# Configura o AllowOverride para o .htaccess funcionar
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

EXPOSE 80