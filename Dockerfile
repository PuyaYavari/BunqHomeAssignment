FROM php:7
RUN apt-get update -y && apt-get install -y openssl zip unzip git && apt-get install -y sqlite3 libsqlite3-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /app
COPY . /app
RUN composer install
CMD composer update && sqlite3 database/ChatDB.db < init.sql && php -S 0.0.0.0:8000 -t public