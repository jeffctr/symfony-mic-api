FROM php:7.4-apache

COPY code /var/www/html

# Installing Composer dependencies
RUN buildDeps=" \
        wget \
        git \
        ssh \
        less \
        unzip \
        zip \
        curl \
        vim \
        sqlite3 \
        libpq-dev \
    "; \
    set -x \
    && apt-get update \
    && apt-get install -y $buildDeps --no-install-recommends && rm -rf /var/lib/apt/lists/*

# Installing Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && export PATH=/root/composer/vendor/bin:$PATH \
    && composer self-update

# Installing Database connection
RUN docker-php-ext-install mysqli pdo pdo_pgsql pdo_mysql

# Installing logs
RUN mkdir -p /var/cache/symfony /var/log/symfony /var/spool/symfony

WORKDIR /var/www/html
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/ && \
    cp /etc/apache2/mods-available/headers.load /etc/apache2/mods-enabled/

RUN /usr/local/bin/composer install

EXPOSE 8080
