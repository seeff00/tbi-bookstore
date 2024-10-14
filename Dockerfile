FROM php:8.4.0RC2-fpm

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    vim \
    gettext \
    locales \
    --no-install-recommends \
    && rm -r /var/lib/apt/lists/* \
    && sed -i 's/# bg_BG.UTF-8 UTF-8/bg_BG.UTF-8 UTF-8/' /etc/locale.gen \
    && sed -i 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen \
    && sed -i 's/# bg_BG/bg_BG/' /etc/locale.gen \
    && sed -i 's/# en_US/en_US/' /etc/locale.gen \
    && locale-gen
    
RUN apt-get update && \
    docker-php-ext-install gettext && \
    docker-php-ext-enable gettext

RUN docker-php-ext-install zip
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install mbstring

RUN locale-gen en_US.UTF-8

# Clear cache
RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www/

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer