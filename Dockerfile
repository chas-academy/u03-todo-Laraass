FROM php:8.3.14-apache

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require squizlabs/php_codesniffer --no-progress --no-suggest
ENV PATH="/root/.composer/vendor/bin:${PATH}"

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]