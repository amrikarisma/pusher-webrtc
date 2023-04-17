FROM php:7.4-fpm
COPY php.ini /usr/local/etc/php/

RUN apt-get update
RUN apt-get install -y libonig-dev \
    libzip-dev \
    unzip \
    mariadb-client \
    libpng-dev \
    libgmp-dev
RUN docker-php-ext-install pdo_mysql mysqli mbstring zip exif gd gettext

# install Composer
COPY --from=composer/composer /usr/bin/composer /usr/bin/composer

# Install Vim
RUN apt-get update && apt-get -y install vim

# Install Node.js
RUN apt-get install -y curl gnupg
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs
# RUN npm install npm@latest -g

RUN apt-get update && apt-get install -y \
    libbz2-dev

# Install GD & exif
# RUN apt-get update && apt-get install -y \
#     libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev \
#     && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
#     && docker-php-ext-install -j$(nproc) gd exif