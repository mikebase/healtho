FROM php:8.3-fpm
RUN apt-get update
RUN apt-get install -y autoconf pkg-config libssl-dev libzip-dev gcc make libc-dev unzip git
RUN docker-php-ext-install bcmath pdo pdo_mysql mysqli zip

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

WORKDIR /home/healtho

ENTRYPOINT ["php", "-S", "0.0.0.0:8080", "-t", "/home/healtho/public"]