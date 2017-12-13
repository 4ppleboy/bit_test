FROM php:7.1-fpm

ENV DEBIAN_FRONTEND="noninteractive" \
    COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/bittest

RUN apt-get update -q && \
    echo 'en_US.UTF-8 UTF-8' > /etc/locale.gen && \
    cp /usr/share/zoneinfo/UTC /etc/localtime && echo "UTC" > /etc/timezone && \
    apt-get install -qy \
        locales && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get update -q && \
    apt-get install -qy --no-install-recommends \
        libzip-dev && \
    pecl install \
        zip \
        xdebug && \
    docker-php-ext-install \
        pdo \
        pdo_mysql && \
    docker-php-ext-enable \
        zip \
        xdebug && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ENV LANG="en_US.UTF-8" \
    LC_ALL="en_US.UTF-8" \
    LANGUAGE="en_US.UTF-8"
    
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.remote_port=9005" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.file_link_format=xdebug://%f@%l" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.var_display_max_depth=8" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.show_local_vars=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.overload_var_dump=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ADD php.ini /usr/local/etc/php/
COPY pool.conf /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000

VOLUME /var/www/bittest