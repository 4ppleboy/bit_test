FROM debian:jessie

ENV DEBIAN_FRONTEND="noninteractive"

WORKDIR /var/www/bittest

RUN apt-get update -q && \
    echo 'en_US.UTF-8 UTF-8' > /etc/locale.gen && \
    cp /usr/share/zoneinfo/UTC /etc/localtime && echo "UTC" > /etc/timezone && \
    apt-get install -qy \
        locales && \
    apt-get install --no-install-recommends -qy \
        nginx && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ENV LANG="en_US.UTF-8" \
    LC_ALL="en_US.UTF-8" \
    LANGUAGE="en_US.UTF-8"

RUN ln -s /etc/nginx/sites-available/bittest.dev.conf /etc/nginx/sites-enabled/bittest.dev && \
    rm /etc/nginx/sites-enabled/default

RUN usermod -u 1000 www-data

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

ADD nginx.conf /etc/nginx/
ADD bittest.dev.conf /etc/nginx/sites-available/

CMD ["nginx"]

EXPOSE 80