FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    apache2 \
    php8.1 \
    php8.1-mysql \
    php8.1-pdo \
    libapache2-mod-php8.1 \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite php8.1

COPY . /var/www/html/

RUN sed -i 's|/var/www/html|/var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2ctl", "-D", "FOREGROUND"]