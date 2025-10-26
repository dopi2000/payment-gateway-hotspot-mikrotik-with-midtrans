FROM php:8.4-fpm

COPY composer.*  /var/www/payment-hotspot-app/

WORKDIR  /var/www/payment-hotspot-app

RUN apt-get update && apt-get install -y \
build-essential \
libmcrypt-dev \
libpng-dev \
libjpeg62-turbo-dev \
libfreetype6-dev \
locales \
jpegoptim optipng pngquant gifsicle \
vim \
nano \
unzip \
git \
curl \
libzip-dev \
zip \
libicu-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql gd zip intl sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . .

COPY --chown=www:www . .

USER www

EXPOSE 9000

CMD ["php-fpm"]